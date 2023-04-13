<template>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="img/agora-logo.png" alt="Agora Logo" class="img-fuild"/>
                </div>
            </div>
        </div>
        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <div class="btn-group" role="group">
                        <button
                            type="button"
                            class="btn btn-primary mr-2"
                            v-for="user in allusers"
                            :key="user.id"
                            @click="placeCall(user.id, user.name)"
                        >
                            Call {{ user.name }}
                            <span class="badge badge-light">{{
                                    getUserOnlineStatus(user.id)
                                }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Incoming Call  -->
            <div class="row my-5" v-if="incomingCall">
                <div class="col-12">
                    <p>
                        Incoming Call From <strong>{{ incomingCaller }}</strong>
                    </p>
                    <div class="btn-group" role="group">
                        <button
                            type="button"
                            class="btn btn-danger"
                            data-dismiss="modal"
                            @click="declineCall"
                        >
                            Decline
                        </button>
                        <button
                            type="button"
                            class="btn btn-success ml-5"
                            @click="acceptCall"
                        >
                            Accept
                        </button>
                    </div>
                </div>
            </div>
            <!-- End of Incoming Call  -->
        </div>

        <section id="video-container">
            <div id="local-video"></div>
            <div id="remote-video"></div>

            <div class="action-btns">
                <button type="button" class="btn btn-info" @click="handleAudioToggle">
                    {{ mutedAudio ? "Unmute" : "Mute" }}
                </button>
                <button
                    type="button"
                    class="btn btn-primary mx-4"
                    @click="handleVideoToggle"
                >
                    {{ mutedVideo ? "ShowVideo" : "HideVideo" }}
                </button>
                <button type="button" class="btn btn-danger" @click="endCall">
                    EndCall
                </button>
            </div>
        </section>
    </main>
</template>

<script>
import AgoraRTC from "agora-rtc-sdk-ng";
import {markRaw} from "vue";

export default {
    name: "AgoraChat",
    props: ["authuser", "authuserid", "allusers", "agora_id"],
    data() {
        return {
            callPlaced: false,
            client: null,
            localVideoStream: null,
            localAudioStream: null,
            mutedAudio: false,
            mutedVideo: false,
            userOnlineChannel: null,
            onlineUsers: [],
            incomingCall: false,
            incomingCaller: "",
            agoraChannel: null,
        };
    },

    mounted() {
        this.initUserOnlineChannel();
        this.initUserOnlineListeners();
    },

    methods: {
        /**
         * Presence Broadcast Channel Listeners and Methods
         * Provided by Laravel.
         * Websockets with Pusher
         */
        initUserOnlineChannel() {
            this.userOnlineChannel = window.Echo.join("agora-online-channel");
        },

        initUserOnlineListeners() {
            this.userOnlineChannel.here((users) => {
                this.onlineUsers = users;
            });

            this.userOnlineChannel.joining((user) => {
                // check user availability
                const joiningUserIndex = this.onlineUsers.findIndex(
                    (data) => data.id === user.id
                );
                if (joiningUserIndex < 0) {
                    this.onlineUsers.push(user);
                }
            });

            this.userOnlineChannel.leaving((user) => {
                const leavingUserIndex = this.onlineUsers.findIndex(
                    (data) => data.id === user.id
                );
                this.onlineUsers.splice(leavingUserIndex, 1);
            });

            // listen to incomming call
            this.userOnlineChannel.listen("MakeAgoraCall", ({data}) => {
                if (parseInt(data.userToCall) === parseInt(this.authuserid)) {
                    const callerIndex = this.onlineUsers.findIndex(
                        (user) => user.id === data.from
                    );
                    this.incomingCaller = this.onlineUsers[callerIndex]["name"];
                    this.incomingCall = true;

                    // the channel that was sent over to the user being called is what
                    // the receiver will use to join the call when accepting the call.
                    this.agoraChannel = data.channelName;
                    console.log("Inncomming call triggered");
                }
            });
        },

        getUserOnlineStatus(id) {
            const onlineUserIndex = this.onlineUsers.findIndex(
                (data) => data.id === id
            );
            if (onlineUserIndex < 0) {
                return "Offline";
            }
            return "Online";
        },

        async placeCall(id, calleeName) {
            try {
                // channelName = the caller's and the callee's id. you can use anything. tho.
                const channelName = `${this.authuser}_${calleeName}`;
                const tokenRes = await this.generateToken(channelName);

                // Broadcasts a call event to the callee and also gets back the token
                await axios.post("/agora/call-user", {
                    user_to_call: id,
                    username: this.authuser,
                    channel_name: channelName,
                });
                console.log("Calling Initialize Agora");
                this.initializeAgora();
                await this.joinRoom(tokenRes.data, channelName);
                this.callPlaced = true;

            } catch (error) {
                console.log(error);
            }
        },

        async acceptCall() {
            this.initializeAgora();
            const tokenRes = await this.generateToken(this.agoraChannel);
            this.joinRoom(tokenRes.data, this.agoraChannel);
            this.incomingCall = false;
            this.callPlaced = true;
        },

        declineCall() {
            // You can send a request to the caller to
            // alert them of rejected call
            this.incomingCall = false;
        },

        generateToken(channelName) {
            return axios.post("/agora/token", {
                channelName,
            });
        },

        /**
         * Agora Events and Listeners
         */
        initializeAgora() {
            this.client = markRaw(AgoraRTC.createClient({mode: "rtc", codec: "h264"}));
        },

        async joinRoom(token, channel) {
            console.log("called join room");
            await this.client.join(
                this.agora_id,
                channel,
                token,
                0,
            );
            await this.createLocalStream();
            this.client.on('user-published', this.handleUserPublished)
            this.client.on('user-unpublished', this.handleUserLeft)
        },

        async initializedAgoraListeners() {
            //   Register event listeners
            console.warn("Events Registered");
            this.client.on("user-published", async (user, mediaType) => {
                await this.client.subscribe(user, mediaType);
                console.error("Subscription success");
                console.warn()
                if (mediaType === "video") {
                    console.log("subscribe video success");
                    user.videoTrack.play("remote-video");
                }
                if (mediaType === "audio") {
                    console.log("subscribe audio success");
                    user.audioTrack.play();
                }
            })

            this.client.on("user-unpublished", (evt) => {
                console.log(evt);
            });
        },

        async handleUserPublished(user, mediaType) {
            this.onlineUsers[user.uid] = user

            // Initiate the Subscription
            await this.client.subscribe(user, mediaType);

            let sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
            await sleep(5000);

            if (mediaType === 'audio') {
                let audioTrack = user.audioTrack
                audioTrack.play()
            } else {
                let videoTrack = user.videoTrack
                videoTrack.play(`user-${user.uid}`)
            }
        },

        async handleUserLeft(user) {
            console.warn("user Left")
        },

        async createLocalStream() {
            this.localAudioStream = await AgoraRTC.createMicrophoneAudioTrack();
            this.localVideoStream = await AgoraRTC.createCameraVideoTrack();
            let sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
            await sleep(500);

            await this.localVideoStream.play('local-video');
            await this.client.publish(this.localVideoStream);
        },

        endCall() {
            this.localStream.close();
            this.client.leave(
                () => {
                    console.log("Leave channel successfully");
                    this.callPlaced = false;
                },
                (err) => {
                    console.log("Leave channel failed");
                }
            );
        },

        handleAudioToggle() {
            if (this.mutedAudio) {
                this.localStream.unmuteAudio();
                this.mutedAudio = false;
            } else {
                this.localStream.muteAudio();
                this.mutedAudio = true;
            }
        },

        handleVideoToggle() {
            if (this.mutedVideo) {
                this.localStream.unmuteVideo();
                this.mutedVideo = false;
            } else {
                this.localStream.muteVideo();
                this.mutedVideo = true;
            }
        },
    },
};
</script>

<style scoped>
main {
    margin-top: 50px;
}

#video-container {
    width: 700px;
    height: 500px;
    max-width: 90vw;
    max-height: 50vh;
    margin: 0 auto;
    border: 1px solid #099dfd;
    position: relative;
    box-shadow: 1px 1px 11px #9e9e9e;
    background-color: #fff;
}

#local-video {
    width: 30%;
    height: 30%;
    position: absolute;
    left: 10px;
    bottom: 10px;
    border: 1px solid #fff;
    border-radius: 6px;
    z-index: 2;
    cursor: pointer;
}

#remote-video {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    z-index: 1;
    margin: 0;
    padding: 0;
    cursor: pointer;
}

.action-btns {
    position: absolute;
    bottom: 20px;
    left: 50%;
    margin-left: -50px;
    z-index: 3;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}

#login-form {
    margin-top: 100px;
}
</style>

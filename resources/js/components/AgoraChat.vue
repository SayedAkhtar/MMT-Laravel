<style scoped>
@import '../../css/app.css';
</style>
<template>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,500,700&display=swap" rel="stylesheet">
    <div class="app-container">
        <div :class="this.localVideoStream != null ? 'loader' : 'loader show'">
            <img src="/img/loader.gif" alt="">
        </div>
        <div class="app-main">
            <div class="video-call-wrapper">

                <div v-if="this.remoteUsers.length == 0" class="video-participant main-user">
                    <ul class="participant-actions">
                        <button class="btn-mute"></button>
                        <button class="btn-camera"></button>
                    </ul>
                    <a href="#" class="name-tag">Loby</a>
                    <img src="https://images.unsplash.com/photo-1566821582776-92b13ab46bb4?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                        alt="participant">
                </div>

                <div v-for="(data, index) in this.remoteUsers" :key="data.uid" class="video-participant main-user"
                    :id="'remote-video-' + data.uid">

                    <a href="#" class="name-tag">{{ this.getName(data.uid) }} <p>{{ !data.audio ? 'Muted' : "" }} </p></a>
                    <img v-if="this.patientJoined === false"
                        src="https://images.unsplash.com/photo-1566821582776-92b13ab46bb4?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                        alt="participant">
                    <img v-if="data.video === false" src="https://www.doctorm.in/assets/images/novideo.png"
                        alt="participant">
                </div>

                <div class="video-participant remote-user" id="local-video">
                    <div class="participant-actions">
                        <button class="btn-mute"></button>
                        <button class="btn-camera"></button>
                    </div>
                    <a href="#" class="name-tag">{{ this.authuser }}</a>
                    <img v-if="this.localVideoStream == null"
                        src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1650&q=80"
                        alt="participant">

                </div>
            </div>
            <div class="video-call-actions">
                <button class="video-action-button mic"
                    :style="{ 'background-color': this.mutedAudio ? 'lightgrey' : 'white' }"
                    @click="handleAudioToggle"></button>
                <button class="video-action-button camera"
                    :style="{ 'background-color': this.mutedVideo ? 'lightgrey' : 'white' }"
                    @click="handleVideoToggle"></button>
                <button class="video-action-button endcall" @click="endCall">Leave</button>
                <button class="video-action-button" @click="toggleChatWindow">
                    <span class="message-counter" v-if="this.incommingMsg > 0">{{ this.incommingMsg }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-message-circle">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="right-side" :class="showChat">
            <ChatWindow :authuserid="this.authuserid"></ChatWindow>
            <button class="expand-btn hide-chat" @click="toggleChatWindow">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px"
                    viewBox="0 0 122.878 122.88" enable-background="new 0 0 122.878 122.88" xml:space="preserve">
                    <g>
                        <path
                            d="M1.426,8.313c-1.901-1.901-1.901-4.984,0-6.886c1.901-1.902,4.984-1.902,6.886,0l53.127,53.127l53.127-53.127 c1.901-1.902,4.984-1.902,6.887,0c1.901,1.901,1.901,4.985,0,6.886L68.324,61.439l53.128,53.128c1.901,1.901,1.901,4.984,0,6.886 c-1.902,1.902-4.985,1.902-6.887,0L61.438,68.326L8.312,121.453c-1.901,1.902-4.984,1.902-6.886,0 c-1.901-1.901-1.901-4.984,0-6.886l53.127-53.128L1.426,8.313L1.426,8.313z" />
                    </g>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import AgoraRTC from "agora-rtc-sdk-ng";
import { markRaw } from "vue";
import ChatWindow from "./ChatWindow.vue";

export default {
    name: "AgoraChat",
    components: { ChatWindow, },
    props: ["authuser", "authuserid", "agora_id", "channelName"],
    data() {
        return {
            callPlaced: false,
            client: null,
            patientJoined: false,
            localVideoStream: null,
            localAudioStream: null,
            mutedAudio: false,
            mutedVideo: false,
            showChat: "",
            remoteUsers: [],
        };
    },
    computed: {
        console: () => console,
        uniqueRemoteUsers: () => {
            const uniqueUids = new Set();
            // Filter the array to keep only objects with unique uid values
            return this.remoteUsers.filter(obj => {
                // If uid is not in the Set, add it and return true (to keep the object)
                if (!uniqueUids.has(obj.uid)) {
                    uniqueUids.add(obj.uid);
                    return true;
                }
                // If uid is already in the Set, return false (to remove the object)
                return false;
            });
        }
    },

    mounted() {
        this.placeCall();
        this.remoteUsers = [];
    },
    created() {
    },

    methods: {
        async placeCall(id, calleeName) {
            try {
                // channelName = the caller's and the callee's id. you can use anything. tho.
                const channelName = `${this.channelName}`;
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

        /**
         * Agora Events and Listeners
         */
        initializeAgora() {
            AgoraRTC.setLogLevel(4)
            this.client = markRaw(AgoraRTC.createClient({ mode: "rtc", codec: "h264" }));
            this.client.on('subscribe', this.handleUserPublished)
            this.client.on('user-published', this.handleUserPublished)
            this.client.on('unsubscribe', this.handleUserLeft)
            this.client.on('user-left', this.handleUserLeft)
            this.client.on('user-unpublished', this.handleUserUnPublished)
            console.warn("Agora Initialized");
        },

        async joinRoom(token, channel) {
            await this.client.join(
                this.agora_id,
                this.channelName,
                null
            );
            await this.createLocalStream();
        },

        generateToken(channelName) {
            console.warn("Call Placed");
            return axios.post("/agora/token", {
                channelName,
            });
        },
        async handleUserSubscribed(user, mediaType) {
            this.console.log("Remote User Subs Cribed", user);
        },

        async handleUserPublished(user, mediaType) {
            this.console.log("Remote User Published");
            const uniqueUids = new Set();
            if (mediaType == 'video') {
                user.video = true;
            }
            if (mediaType == 'audio') {
                user.audio = true;
            }
            this.console.log(user);
            this.remoteUsers.push(user);
            this.remoteUsers = this.remoteUsers.filter(obj => {
                if (!uniqueUids.has(obj.uid)) {
                    uniqueUids.add(obj.uid);
                    return true;
                }
                return false;
            });
            await this.subscribe(user, mediaType);
            this.patientJoined = true;
        },
        async handleUserUnPublished(user, mediaType) {
            this.console.log(mediaType);
            this.remoteUsers.forEach((item, index) => {
                if (item.uid === user.uid) {
                    if (mediaType == 'video') {
                        this.remoteUsers[index].video = false;
                    }
                    if (mediaType == 'audio') {
                        this.remoteUsers[index].audio = false;
                    }
                }
            });
        },

        async handleUserLeft(user) {
            this.console.log(user);
            this.remoteUsers = this.remoteUsers.filter(item => item.uid !== user.uid);
        },

        async createLocalStream() {
            try {
                this.localAudioStream = await AgoraRTC.createMicrophoneAudioTrack();
                this.localVideoStream = await AgoraRTC.createCameraVideoTrack();
                await this.localVideoStream.play('local-video');
                await this.localAudioStream.play();
                await this.client.publish(this.localVideoStream);
                await this.client.publish(this.localAudioStream);
            } catch {
                alert("Could not find any camera or audio devices. Please give permission to access Audio/Video");
            }

        },

        endCall() {
            this.localVideoStream.close();
            this.localAudioStream.close();
            if (confirm("Close Call?")) {
                this.client.leave(
                    () => {
                        console.log("Leave channel successfully");
                        this.callPlaced = false;
                        this.localVideoStream = null;
                    },
                    (err) => {
                        console.log("Leave channel failed");
                    }
                );
                setTimeout(()=>{close();}, 2000);
                
            }

        },

        handleAudioToggle() {
            this.mutedAudio = !this.mutedAudio
            this.localAudioStream.setMuted(this.mutedAudio);
        },

        handleVideoToggle() {
            this.mutedVideo = !this.mutedVideo
            this.localVideoStream.setMuted(this.mutedVideo);
        },

        async subscribe(user, mediaType) {
            await this.client.subscribe(user, mediaType);
            if (mediaType === 'audio') {
                let audioTrack = user.audioTrack
                audioTrack.play()
            } else {
                let videoTrack = user.videoTrack
                videoTrack.play(`remote-video-${user.uid}`)
            }

        },

        toggleChatWindow() {
            if (this.showChat == "show") {
                this.showChat = "";
            } else {
                this.showChat = "show";
                this.incommingMsg = 0;
            }
        },

        getName(user_id) {
            if (user_id == 1)
                return "Patient";
            if (user_id == 4)
                return "Doctor";
            if (user_id == 2)
                return "Admin";
            if (user_id == "3")
                return "MMT HCF";
            else
                return "User";
        }

    },
};
</script>

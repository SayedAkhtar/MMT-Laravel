<template>
    <div class="chat-container">
        <ul class="chat-area" ref="messageList">
            <li v-for="message in Object.entries(this.messages)" :key="message[0]" class="message-wrapper"
                :class="{ reverse: message[1].from !== 1 }">
                <div class="message-content">
                    <p class="name">{{ this.getName(message[1].from ) }}</p>
                    <div class="message">
                        <p class="message-text" v-if="message[1].type === 'text'"><span style="word-wrap: break-word;">{{
                            message[1].message
                        }}</span></p>
                        <span class="message-image" v-if="message[1].type === 'image'">
                            <a :href="message[1].message">
                                <img class="message-image--img" :src="message[1].message" alt="">
                            </a>
                        </span>
                        <span v-if="message[1].type === 'file'">{{ message[1].message }}</span>
                    </div>
                </div>
            </li>
        </ul>
        <div class="chat-typing-area-wrapper">
            <div class="chat-typing-area">
                <input type="text" placeholder="Type your meesage..." class="chat-input" v-model="message"
                    @keydown.enter="sendMessage">
                <button class="send-button" @click="uploadFile" style="margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-file-plus">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                </button>
                <input type="file" id="uploadFile" style="display: none;" />
                <button class="send-button" @click="sendMessage" id="submit" style="margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-send" viewBox="0 0 24 24">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { markRaw, nextTick } from "vue";
import { initializeApp } from "firebase/app";
import { getDatabase, ref, onValue, child, get, set, push } from 'firebase/database';
import { getStorage, ref as storageRef, uploadBytes, getDownloadURL } from "firebase/storage";

export const firebaseConfig = {
    apiKey: "AIzaSyB3zpdPFZHof19ydzy6XYqSYEoafYvKIi8",
    authDomain: "mymedtrip-app.firebaseapp.com",
    databaseURL: "https://mymedtrip-app-default-rtdb.firebaseio.com",
    projectId: "mymedtrip-app",
    storageBucket: "mymedtrip-app.appspot.com",
    messagingSenderId: "922681658193",
    appId: "1:922681658193:web:0c19c89833e51c376aa170",
    measurementId: "G-ELKMH046XM"
};

export const firebaseApp = initializeApp(firebaseConfig);
const db = getDatabase(firebaseApp);

export default {
    name: "ChatWindow",
    props: ["authuserid"],
    data() {
        return {
            showChat: "",
            firebaseApp: null,
            messages: [],
            message: "",
            messageType: "text",
            incommingMsg: 0,
            messagesFetched: false
        };
    },
    mounted() {
        console.log("Called");
        const messagesRef = ref(db, 'messages/' + this.channelName)
        get(child(ref(db), 'messages/' + this.channelName)).then((snapshot) => {
            if (snapshot.exists()) {
                this.messages = snapshot.val();
            } else {
                console.log("No data available");
            }
        }).catch((error) => {
            console.error(error);
        });
        onValue(messagesRef, (snapshot) => {
            const currentSize = Object.entries(this.messages).length;
            if (snapshot.exists()) {
                this.messages = snapshot.val();
            }
            if (this.messagesFetched) {
                this.incommingMsg = Object.entries(this.messages).length - currentSize;
            }
            this.messagesFetched = true;
            this.messageScrollBottom();
        });
    },
    created() {
    },

    methods: {
        async sendMessage() {
            // const messagesRef = ref(db, 'messages/' + this.channelName)
            // const newMessageRef = push(messagesRef);
            // set(newMessageRef, {
            //     from: this.authuserid,
            //     message: this.message,
            //     type: "text",
            // });
            console.log(this.authuserid);
            await nextTick();
            this.messageScrollBottom();
            this.message = "";
            await fetch('https://admin.mymedtrip.com/notify-message/' + this.channelName);
        },
        uploadFile() {
            const storage = getStorage();
            document.querySelector("#uploadFile").click();
            document.querySelector("#uploadFile").onchange = () => {
                if (document.querySelector("#uploadFile").files.length > 0) {
                    document.querySelector("#submit").disabled = false;
                    let file = document.querySelector("#uploadFile").files[0];
                    let type = file.type.split('/')[0] == 'image' ? 'image' : 'file';
                    let path = "messages/" + this.channelName + '/' + file.name;
                    const fileRef = storageRef(storage, path);
                    document.querySelector('.loader').style.display = 'flex';
                    uploadBytes(fileRef, file).then((snapshot) => {
                        console.log('Uploaded a blob or file!');
                        getDownloadURL(fileRef).then((url) => {
                            console.log(url);
                            const messagesRef = ref(db, 'messages/' + this.channelName)
                            const newMessageRef = push(messagesRef);
                            set(newMessageRef, {
                                from: 4,
                                message: url,
                                type: type,
                            });
                            document.querySelector('.loader').style.display = 'none';
                        });
                    });
                }
            }
        },
        messageScrollBottom() {
            var t = document.querySelector('.chat-area');
            t.scrollTo({
                top: t.scrollHeight + 10000000,
                left: 0,
                behavior: 'smooth'
            });
        },
        getName(user_id){
            if(user_id == 1)
                return "Patient";
            if(user_id == 4)
                return "Doctor";
            if(user_id == 2)
                return "Admin";
            if(user_id == "3")
                return "MMT HCF";
            else
                return "User";
        }

    },
};
</script>

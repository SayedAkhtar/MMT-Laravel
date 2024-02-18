<style scoped>
* {
    box-sizing: border-box;
}

html,
body {
    width: 100%;
    height: 100vh;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

button {
    outline: none;
    transition: 0.2s;
    cursor: pointer;
}

button:hover {
    opacity: 0.7;
}

body {
    --app-background: #eaebf5;
    --chat-background: #fff;
    --link-color: #c0c1c5;
    --navigation-bg: #fff;
    --navigation-box-shadow: 0 2px 6px 0 rgba(136, 148, 171, 0.2), 0 24px 20px -24px rgba(71, 82, 107, 0.1);
    --main-color: #3d42df;
    --message-bg: #f3f4f9;
    --message-bg-2: #3d42df;
    --message-text: #2c303a;
    --placeholder-text: #a2a4bc;
    --button-bg: #fff;
}

body.dark {
    --app-background: #262a42;
    --navigation-box-shadow: 0px 0px 8px 0px #282b33;
    --chat-background: #3c3f56;
    --message-bg: #2c3046;
    --message-text: rgba(255, 255, 255, 0.8);
    --placeholder-text: #fff;
    --navigation-bg: #3c3f56;
    --button-bg: #3c3f56;
    --main-color: #6f74ff;
    --message-bg-2: #6f74ff;
}

body.dark .mic {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-mic-off' viewBox='0 0 24 24'%3E%3Cpath d='M1 1l22 22M9 9v3a3 3 0 005.12 2.12M15 9.34V4a3 3 0 00-5.94-.6'/%3E%3Cpath d='M17 16.95A7 7 0 015 12v-2m14 0v2a7 7 0 01-.11 1.23M12 19v4M8 23h8'/%3E%3C/svg%3E%0A");
}



body.dark .camera {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-camera-off' viewBox='0 0 24 24'%3E%3Cpath d='M1 1l22 22M21 21H3a2 2 0 01-2-2V8a2 2 0 012-2h3m3-3h6l2 3h4a2 2 0 012 2v9.34m-7.72-2.06a4 4 0 11-5.56-5.56'/%3E%3C/svg%3E%0A");
}

body.dark .maximize {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-maximize' viewBox='0 0 24 24'%3E%3Cpath d='M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3'/%3E%3C/svg%3E%0A");
}

body.dark .magnifier {
    color: #fff;
}

body.dark .chat-header {
    border-color: var(--message-bg);
}

body.dark .btn-close-right {
    color: #fff;
}

a {
    text-decoration: none;
}

.app-container {
    background-color: var(--app-background);
    max-width: 500px;
    height: 100vh;
    font-family: "DM Sans", sans-serif;
    display: flex;
    transition: 0.2s;
    position: relative;
    margin: 0 auto;
    overflow-x: hidden;
}

.left-side {
    position: relative;
    padding: 16px;
    flex-basis: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.navigation {
    display: flex;
    flex-direction: column;
    background-color: var(--navigation-bg);
    padding: 24px;
    border-radius: 10px;
    box-shadow: var(--navigation-box-shadow);
}

.nav-link+.nav-link {
    margin-top: 32px;
}

.nav-link:hover svg {
    color: #3d42df;
}

.icon svg {
    width: 24px;
    height: 24px;
    color: var(--link-color);
    transition: 0.2s ease-in;
}

.right-side {
    left: 0px;
    width: 100%;
    margin-left: auto;
    flex-basis: 400px;
    height: 100%;
    position: absolute;
    background: #fff;
    transition: all 300ms cubic-bezier(0.19, 1, 0.56, 1);
    transform: translateX(-110%);
    display: flex;
    justify-content: space-around;
    flex-direction: column;
    z-index: 15;
}

.right-side.show {
    transform: translateX(0);
}

.chat-container {
    background-color: #fff3cd;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    height: calc(100% - 72px);
}

.chat-header {
    padding: 16px;
    border-bottom: 1px solid #f5f5f5;
}

.chat-header-button {
    background-color: var(--main-color);
    padding: 12px 16px 12px 40px;
    border: none;
    border-radius: 4px;
    color: #fff;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg' fill='%23fff'%3E%3Cpath d='M479.9 187.52l-90.19 68.53v-52.6a20 20 0 00-20-20H20a20 20 0 00-20 20V492a20 20 0 0020 20h349.71a20 20 0 0020-20v-52.6l90.18 68.52c13.05 9.91 32.1.67 32.1-15.92V203.45c0-16.5-18.94-25.92-32.1-15.93zM349.7 472H40V223.45h309.71zM472 451.68l-82.29-62.53V306.3L472 243.77zM87.96 79.24C129.62 28.88 190.86 0 256 0c65.13 0 126.37 28.88 168.03 79.24a20 20 0 01-30.82 25.5A177.6 177.6 0 00256 40a177.6 177.6 0 00-137.21 64.73 20 20 0 11-30.83-25.5zm240.36 32.21a20 20 0 11-21.02 34.03 97.57 97.57 0 00-51.3-14.53 97.6 97.6 0 00-51.31 14.53 20 20 0 11-21.02-34.03A137.53 137.53 0 01256 90.95c25.59 0 50.6 7.09 72.32 20.5zm0 0'/%3E%3C/svg%3E%0A");
    background-repeat: no-repeat;
    background-position: center left 12px;
    background-size: 16px;
    font-size: 14px;
}

.chat-area {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
}

.profile-picture {
    border-radius: 8px;
    width: 32px;
    height: 32px;
    overflow: hidden;
    margin-right: 12px;
    flex-shrink: 0;
}

.profile-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.message-wrapper {
    display: flex;
}

.name {
    margin: 0;
    line-height: 16px;
    font-size: 12px;
    font-weight: 700;
    color: var(--message-text);
}

.message {
  margin-top: 8px;
  padding: 8px 16px;
  border-radius: 0 12px 12px 12px;
  font-size: 12px;
  line-height: 16px;
  max-width: 60%;
  color: var(--message-text);
  background: #fff;
  box-sizing: content-box;
}

.message-wrapper.reverse {
  flex-direction: row-reverse;
}

.message-wrapper.reverse .message {
  color: #000;
  margin-left: auto;
  border-radius: 16px 0px 16px 16px;
  text-align: right;
  background: #fff;
  box-sizing: content-box;
}

.message-wrapper.reverse .profile-picture {
  margin-right: 0px;
  margin-left: 12px;
}

.message-wrapper.reverse .name {
  text-align: right;
}

.message p {
  width: 100%;
  min-width: 100px;
  text-align: left;
}

.message-image--img {
  max-width: 100%;
}

.message-file {
  border: 1px solid var(--message-bg);
  width: 100%;
  margin-top: 16px;
  border-radius: 4px;
  padding: 8px;
  display: flex;
}

.message-file .sketch {
    border-radius: 4px;
    padding: 2px;
    background-color: #fdeee2;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 32px;
    height: 32px;
}

.message-file .sketch svg {
    width: 20px;
    height: 20px;
}

.file-info {
    flex: 1;
    padding: 0 40px 0 8px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23b8b8b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-download' viewBox='0 0 24 24'%3E%3Cpath d='M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3'/%3E%3C/svg%3E%0A");
    background-position: center right 12px;
    background-size: 20px;
    background-repeat: no-repeat;
    font-size: 12px;
}

.file-name {
    color: var(--message-text);
}

.file-size {
    color: #b8b8b8;
}

.mention {
    color: #7c80fd;
}

.chat-typing-area-wrapper {
    padding: 16px;
}

.chat-typing-area {
    display: flex;
    border-radius: 10px;
    padding: 8px;
    box-shadow: var(--navigation-box-shadow);
    background-color: var(--message-bg);
}

.dark .chat-typing-area {
    box-shadow: none;
}

.chat-input {
    border: 1px solid;
    border-radius: 100px;
    padding: 0px 10px;
    font-size: 14px;
    line-height: 24px;
    outline: none;
    color: var(--message-text);
    flex: 1;
    background-color: transparent;
}

.chat-input:placeholder {
    color: var(--placeholder-text);
}

.send-button {
    color: #000;
    background-color: var(--main-color);
    border-radius: 8px;
    border: none;
    width: 32px;
    height: 32px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.send-button svg {
    width: 20px;
    height: 20px;
}

.app-main {
    flex: 1;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.video-call-wrapper {
    width: 100%;
    height: 100%;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-wrap: wrap;
    position: relative;
}

.video-participant {
    width: 33.3%;
    position: relative;
}

.video-participant.main-user {
    width: 100%;
    height: auto;
    position: relative;
}

.video-participant.remote-user {
    height: 25%;
    top: 0px;
    left: 0px;
    position: absolute;
}

.video-participant img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.name-tag {
    position: absolute;
    bottom: 12px;
    right: 12px;
    font-size: 12px;
    color: #fff;
    background-color: rgba(0, 15, 47, 0.5);
    border-radius: 4px;
    padding: 4px 12px;
    z-index: 10;
}

.participant-actions {
    position: absolute;
    display: none;
    left: 12px;
    top: 12px;
    z-index: 10;
}

.btn-mute,
.btn-camera {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    background-color: rgba(0, 15, 47, 0.5);
    background-repeat: no-repeat;
    background-position: center;
    background-size: 16px;
    border: none;
}

.btn-mute {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-mic-off' viewBox='0 0 24 24'%3E%3Cpath d='M1 1l22 22M9 9v3a3 3 0 005.12 2.12M15 9.34V4a3 3 0 00-5.94-.6'/%3E%3Cpath d='M17 16.95A7 7 0 015 12v-2m14 0v2a7 7 0 01-.11 1.23M12 19v4M8 23h8'/%3E%3C/svg%3E%0A");
    margin-right: 4px;
}

.btn-camera {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-camera-off' viewBox='0 0 24 24'%3E%3Cpath d='M1 1l22 22M21 21H3a2 2 0 01-2-2V8a2 2 0 012-2h3m3-3h6l2 3h4a2 2 0 012 2v9.34m-7.72-2.06a4 4 0 11-5.56-5.56'/%3E%3C/svg%3E%0A");
}

.video-call-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    padding-bottom: 10px;
    width: 100%;
}

.video-action-button {
    background-repeat: no-repeat;
    background-size: 24px;
    border: none;
    height: 48px;
    margin: 0 8px;
    box-shadow: var(--navigation-box-shadow);
    border-radius: 8px;
    width: 48px;
    cursor: pointer;
    outline: none;
    background-color: var(--button-bg);
    position: relative;
}



.video-action-button.mic {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%232c303a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-mic-off' viewBox='0 0 24 24'%3E%3Cpath d='M1 1l22 22M9 9v3a3 3 0 005.12 2.12M15 9.34V4a3 3 0 00-5.94-.6'/%3E%3Cpath d='M17 16.95A7 7 0 015 12v-2m14 0v2a7 7 0 01-.11 1.23M12 19v4M8 23h8'/%3E%3C/svg%3E%0A");
    background-position: center;
}

.video-action-button.camera {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%232c303a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-camera-off' viewBox='0 0 24 24'%3E%3Cpath d='M1 1l22 22M21 21H3a2 2 0 01-2-2V8a2 2 0 012-2h3m3-3h6l2 3h4a2 2 0 012 2v9.34m-7.72-2.06a4 4 0 11-5.56-5.56'/%3E%3C/svg%3E%0A");
    background-position: center;
}

.video-action-button.maximize {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%232c303a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-maximize' viewBox='0 0 24 24'%3E%3Cpath d='M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3'/%3E%3C/svg%3E%0A");
    background-position: center;
}

.video-action-button.endcall {
    color: #ff1932;
    width: auto;
    font-size: 14px;
    padding-left: 42px;
    padding-right: 12px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ff1932' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-phone-missed'%3E%3Cline x1='23' y1='1' x2='17' y2='7'/%3E%3Cline x1='17' y1='1' x2='23' y2='7'/%3E%3Cpath d='M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z'/%3E%3C/svg%3E");
    background-size: 20px;
    background-position: center left 12px;
}

.video-action-button.magnifier {
    padding: 0 12px;
    display: flex;
    align-items: center;
    width: auto;
    flex-grow: 0;
    color: #2c303a;
}

.video-action-button.magnifier svg {
    width: 20px;
    flex-shrink: 0;
}

.video-action-button.magnifier span {
    display: block;
    margin: 0 16px;
}

.participants {
    display: flex;
    background-color: var(--button-bg);
    box-shadow: var(--navigation-box-shadow);
    margin-top: 16px;
    padding: 12px;
    border-radius: 8px;
    max-width: 232px;
    margin-left: auto;
}

.participant-more {
    background-color: #e1e0e1;
    font-size: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #636181;
    font-weight: 700;
    border-radius: 8px;
    min-width: 32px;
}

.mode-switch {
    z-index: 1;
    position: absolute;
    top: 20px;
    left: 36px;
    background-color: var(--chat-background);
    border: none;
    color: #ddd;
    outline: none;
    cursor: pointer;
    box-shadow: var(--navigation-box-shadow);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    transform-origin: center;
}

.mode-switch svg {
    width: 0;
    height: 24px;
    transition: all 0.3s ease-in;
    transform-origin: center;
}

.mode-switch .moon {
    opacity: 0;
}

.mode-switch .sun {
    width: 24px;
}

.dark .moon {
    opacity: 1;
    width: 24px;
}

.dark .sun {
    opacity: 0;
    width: 0;
}

.expand-btn {
    border: none;
    background-color: var(--chat-background);
    border-radius: 4px;
    color: var(--message-text);
    justify-content: center;
    align-items: center;
    position: relative;
}

.expand-btn.show {
    display: flex;
}
.expand-btn .message-counter{
    position: absolute;
    background: #259ec9;
    color: white;
    font-weight: 700;
    width: 24px;
    height: 24px;
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    top: -10px;
}

.btn-close-right {
    border: none;
    background-color: transparent;
    position: absolute;
    top: 24px;
    right: 24px;
    color: var(--light-font);
    outline: none;
    cursor: pointer;
    display: none;
}

.loader {
    display: flex;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    display: none;
}

.loader img {
    width: 60px;
    height: 60px;
}
</style>
<template>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,500,700&display=swap" rel="stylesheet">
    <div class="app-container">
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
                    <ul class="participant-actions">
                        <button class="btn-mute"></button>
                        <button class="btn-camera"></button>
                    </ul>
                    <a href="#" class="name-tag">{{ data.uid == 1 ? "Patient" : data.uid }}</a>
                    <img v-if="this.patientJoined === false"
                        src="https://images.unsplash.com/photo-1566821582776-92b13ab46bb4?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                        alt="participant">
                </div>

                <div class="video-participant remote-user" id="local-video">
                    <div class="participant-actions">
                        <button class="btn-mute"></button>
                        <button class="btn-camera"></button>
                    </div>
                    <a href="#" class="name-tag">Doctor</a>
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
                <button class="video-action-button endcall">Leave</button>
                <button class="expand-btn" @click="toggleChatWindow">
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
            <div class="chat-container">
                <div class="loader">
                    <img src="/img/loader.gif" alt="">
                </div>
                <div class="chat-area">
                    <div v-for="message in Object.entries(this.messages)" :key="message[0]" class="message-wrapper"
                        :class="{ reverse: message[1].from !== 1 }">
                        <div class="message-content">
                            <p class="name">{{ message[1].from != 1 ? 'Doctor' : 'Patient' }}</p>
                            <div class="message">
                                <p class="message-text" v-if="message[1].type === 'text'"><span
                                        style="word-wrap: break-word;">{{
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
                    </div>
                </div>
                <div class="chat-typing-area-wrapper">
                    <div class="chat-typing-area">
                        <input type="text" placeholder="Type your meesage..." class="chat-input" v-model="message"
                            @keydown.enter="sendMessage">
                        <button class="send-button" @click="uploadFile">
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
                        <button class="send-button" @click="sendMessage" id="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"
                                viewBox="0 0 24 24">
                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
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
import { initializeApp } from "firebase/app";
import { useDatabaseList } from "vuefire";
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
    name: "AgoraChat",
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
            userOnlineChannel: null,
            onlineUsers: [],
            incomingCall: false,
            incomingCaller: "",
            showChat: "",
            firebaseApp: null,
            messages: [],
            message: "",
            messageType: "text",
            remoteUsers: [],
            incommingMsg: 0,
            messagesFetched: false
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
        // this.initUserOnlineChannel();
        // this.initUserOnlineListeners();
        this.placeCall();
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
            this.console.log("SIZE  ==== >>>>>",currentSize, Object.entries(this.messages).length);
            if(this.messagesFetched){
                this.incommingMsg =  Object.entries(this.messages).length - currentSize;
            }
            this.messagesFetched = true;
            this.messageScrollBottom();
        });
        this.remoteUsers = [];
    },
    created() {
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
                console.log(this.onlineUsers);
            });

            this.userOnlineChannel.leaving((user) => {
                const leavingUserIndex = this.onlineUsers.findIndex(
                    (data) => data.id === user.id
                );
                this.onlineUsers.splice(leavingUserIndex, 1);
            });

            // listen to incomming call
            this.userOnlineChannel.listen("MakeAgoraCall", ({ data }) => {
                if (parseInt(data.userToCall) === parseInt(this.authuserid)) {
                    const callerIndex = this.onlineUsers.findIndex(
                        (user) => user.id === data.from
                    );
                    this.incomingCaller = this.onlineUsers[callerIndex]["name"];
                    this.incomingCall = true;

                    // the channel that was sent over to the user being called is what
                    // the receiver will use to join the call when accepting the call.
                    this.agoraChannel = data.channelName;
                    console.log("Incommoding call triggered");
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
            console.log()
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

        async acceptCall() {
            this.initializeAgora();
            const tokenRes = await this.generateToken(this.agoraChannel);
            this.joinRoom(tokenRes.data, this.agoraChannel);
            this.incomingCall = false;
            this.callPlaced = true;
        },

        declineCall() {
            this.incomingCall = false;
        },

        generateToken(channelName) {
            console.warn("Call Placed");
            return axios.post("/agora/token", {
                channelName,
            });
        },

        /**
         * Agora Events and Listeners
         */
        initializeAgora() {
            AgoraRTC.setLogLevel(4)
            this.client = markRaw(AgoraRTC.createClient({ mode: "rtc", codec: "h264" }));
            this.client.on('user-published', this.handleUserPublished)
            this.client.on('user-unpublished', this.handleUserLeft)
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

        async handleUserPublished(user, mediaType) {
            const uniqueUids = new Set();
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

        async handleUserLeft(user) {
            this.remoteUsers = this.remoteUsers.filter(item => item.uid !== user.uid);
        },

        async createLocalStream() {
            this.localAudioStream = await AgoraRTC.createMicrophoneAudioTrack();
            this.localVideoStream = await AgoraRTC.createCameraVideoTrack();
            await this.localVideoStream.play('local-video');
            await this.localAudioStream.play();
            await this.client.publish(this.localVideoStream);
            await this.client.publish(this.localAudioStream);
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
        async sendMessage() {
            this.console.log(this.message);
            const messagesRef = ref(db, 'messages/' + this.channelName)
            const newMessageRef = push(messagesRef);
            set(newMessageRef, {
                from: 4,
                message: this.message,
                type: "text",
            });
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
                top: t.scrollHeight + 1000,
                left: 0,
                behavior: 'smooth'
            });
        }

    },
};
</script>

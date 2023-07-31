<template>
    <el-row v-if="userStore.getUserId != room?.user_id && !joined">
        <el-col :span="8" :offset="8">
            <el-input v-model="roomUser.name" placeholder="Please type your name"/>
            <el-input style="margin-top: 15px;" v-if="room.password != null" v-model="roomUser.password" placeholder="Enter room's password"/>
            <div style="text-align: center;margin-top: 30px;">
                <el-button type="primary" @click="joinRoom">Join</el-button>
            </div>
        </el-col>
    </el-row>
    <el-row v-else>
        <el-col :span="8" :offset="8">
            <div class="waving-text" style="text-align: center;font-size: 25px;font-weight: bold;">
                <span style="--i:1">W</span>
                <span style="--i:2">a</span>
                <span style="--i:3">i</span>
                <span style="--i:4">t</span>
                <span style="--i:5">i</span>
                <span style="--i:6">n</span>
                <span style="--i:7">g</span>
                <span style="padding-left: 10px;"></span>
                <span style="--i:8">f</span>
                <span style="--i:9">o</span>
                <span style="--i:10">r </span>
                <span style="padding-left: 10px;"></span>
                <span style="--i:11">p</span>
                <span style="--i:12">l</span>
                <span style="--i:13">a</span>
                <span style="--i:14">y</span>
                <span style="--i:15">e</span>
                <span style="--i:16">r </span>
                <span style="padding-left: 10px;"></span>
                <span style="--i:17"> t</span>
                <span style="--i:18">o </span>
                <span style="padding-left: 10px;"></span>
                <span style="--i:19"> j</span>
                <span style="--i:20">o</span>
                <span style="--i:21">i</span>
                <span style="--i:22">n</span>
                <span style="--i:23"> .</span>
                <span style="--i:24"> .</span>
                <span style="--i:25"> .</span>

            </div>
        </el-col>
    </el-row>
    <el-row>
        <el-col :span="16" :offset="4" style="margin-top: 30px;">
            <el-tag
                v-for="player in players"
                :key="player.name"
                :type="tagType[Math.floor(Math.random() * tagType.length)]"
                class="mx-1"
                effect="dark"
                size="large"
                round
            >
            <div style="display: flex;align-items: center;">
                <el-avatar
                    :src="`https://i.pravatar.cc/30?u=${player.user_id}`"
                    :size="30"
                    style="margin-right: 10px;"
                />
                <span>
                    {{ player.name }}
                </span>
                </div>
            </el-tag>
        </el-col>
    </el-row>
    <div v-if="userStore.getUserId == room?.user_id" style="display: flex;justify-content: center;margin-top: 30px;">
        <el-button type="primary" @click="startGame">Start Game</el-button>
    </div>
</template>


<script>
import axios from 'axios'
import generateHeader from '~~/composables/common'
import { useAuthUserStore } from '~~/stores/authUserStore'
import Pusher from 'pusher-js'

export default {
    setup () {
        definePageMeta({
            meta: [
                {
                content: 'Room Page'
                }
            ],
            layout: 'quiz',
        })
        const userStore = useAuthUserStore()
        const route = useRoute();
        return {
            userStore
        }
    },
    beforeRouteLeave(to, from, next) {
        
    },
    data() {
        return {
            roomUser: {
                name: '',
                room_id: this.$route.params.id,
                password: ''
            },
            room: null,
            user: null,
            joined: false,
            thisUserId: null,
            players: [],
            tagType: ["success", "info", "warning", "danger", ""]
        }
    },
    mounted() {
        this.getRoom()
        Pusher.logToConsole = true;

        var pusher = new Pusher(PUSHER_APP_KEY, {
            cluster: PUSHER_APP_CLUSTER
        });

        const channel = pusher.subscribe('room.' + this.$route.params.id);

        channel.bind('join-room', (data) => {
            console.log(data.roomUser);
            this.addPlayer(data.roomUser)
        });

        channel.bind('leave-room', (data) => {
            this.removePlayer(data.userId)
        });

        addEventListener("beforeunload", (event) => {
            this.leaveRoom()
        });
    },
    methods: {
        leaveRoom() {
            axios.post(API_URL + 'rooms/' + this.roomUser.room_id + '/leave', {user_id: this.thisUserId}).then(res => {
                console.log(res)
            })
        },
        joinRoom() {
            if (this.roomUser.password == this.room.password) {
                axios.post(API_URL + 'rooms/' + this.roomUser.room_id + '/join', this.roomUser, {
                    headers: {"Access-Control-Allow-Origin": "*"}
                }).then(res => {
                    ElNotification({
                        title: 'Success',
                        message: 'Join room successfully',
                        type: 'success'
                    })
                    this.joined = true
                    this.thisUserId = res.data.roomUser.user_id
                })
            } else {
                ElNotification({
                    title: 'Error',
                    message: 'Wrong password',
                    type: 'error'
                })
            }
        },
        getRoom() {
            axios.get(API_URL + 'rooms/' + this.$route.params.id).then(res => {
                this.room = res.data.room
                console.log(res.data.competitors);
                this.players = res.data.room.competitors
            })   
        },
        addPlayer(player) {
            this.players.push({
                name: player.name,
                score: 0,
                user_id: player.user_id
            })
            thisUserId = player.user_id
        },
        removePlayer(userId) {
            this.players = this.players.filter(player => player.id != userId)
        },
        startGame() {
            axios.post(API_URL + 'rooms/' + this.roomUser.room_id + '/start', {room_id: this.$route.params.id}).then(res => {
                console.log(res)
            })
        }
    }
}
</script>

<style scoped>
input {
    border-radius: 10px;
}

/* waving each character like a flag animation */
.waving-text span{
    animation: animate 1s infinite;
    animation-delay: calc(var(--i) * 0.1s);
    display: inline-block;
}

@keyframes animate {
    0%, 40%, 100% {
        transform: translateY(0);
    }
    20% {
        transform: translateY(-1rem);
    }
}
</style>
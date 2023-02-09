import {defineStore} from "pinia"
import axios from "axios"
import generateHeader from "~/composables/common";

export const useAuthUserStore = defineStore("authUserStore", {
    state: () => ({
        user: null,
    }),
    getters: {
        getUser: (state) => state.user,
    },
    actions: {
        setUser(user: any) {
            this.user = user
        },
        fetchUser() {
            return axios.get(API_URL + 'auth/user', generateHeader()).then((response) => {
                this.setUser(response.data.user)
            })
        }
    }
})
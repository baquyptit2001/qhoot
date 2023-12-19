import {defineStore} from "pinia"
import axios from "axios"
import generateHeader from "~/composables/common";
// @ts-ignore
import Cookies from "js-cookie";
import {API_URL} from "~/composables/constants";

export const useAuthUserStore = defineStore("authUserStore", {
    state: () => ({
        user: null,
    }),
    getters: {
        getUser: (state) => state.user,
        getUserId: (state) => {
            if (state.user == null) {
                return null
            }
            // @ts-ignore
            return state.user.id
        }
    },
    actions: {
        setUser(user: any) {
            this.user = user
        },
        async fetchUser() {
            try {
                let token = Cookies.get('access_token')
                if (token == null) {
                    throw new Error('No token')
                }
                const response = await axios.get(API_URL + 'auth/user', generateHeader());
                if (response.data.user == null) {
                    Cookies.remove('access_token');
                }
                this.setUser(response.data.user);
            } catch (error) {
                Cookies.remove('access_token');
            }
        }
    }
})
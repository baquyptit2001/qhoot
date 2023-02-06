import {defineStore} from "pinia";

export const useClientLayoutStore = defineStore("clientLayoutStore", {
    state: () => ({
        isCollapse: false,
        menuActive: '1',
        breadcrumb: [],
        tags: [
        ],
    }),
    getters: {
        getIsCollapse: (state) => state.isCollapse,
    },
    actions: {
        setIsCollapse() {
            this.isCollapse = !this.isCollapse
        },
        addTag(tag: any) {
            this.tags.forEach((item: any) => {
                item.active = false
            })
            let index = this.tags.findIndex((item: any) => item.name === tag.name)
            tag.active = true
            if (index === -1) {
                // @ts-ignore
                this.tags.push(tag)
            } else {
                // @ts-ignore
                this.tags[index] = tag
            }
        },
        removeTag(tag: any) {
            let index = this.tags.findIndex((item: any) => item.name === tag.name)
            this.tags.splice(index, 1)
        },
        updateBreadcrumb(breadcrumb: any) {
            this.breadcrumb = breadcrumb
        }
    }
})
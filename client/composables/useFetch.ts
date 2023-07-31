import {ref} from 'vue'
import generateHeader from './common'

export default function useFetch(url: string) {
    const data = ref(null)
    const error = ref(null)
    const loading = ref(false)
    const { signal, abort } = new AbortController()

    const headers = generateHeader()

    const options = {
        headers,
        signal
    }

    const fetchData = async () => {
        loading.value = true
        try {
            const res = await fetch(url, options)
            data.value = await res.json()
            loading.value = false
        } catch (err: any) {
            error.value = err.message
            loading.value = false
        }
    }

    return { data, error, loading, fetchData, abort }
}
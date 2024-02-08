//import axios
import axios from 'axios';
import {notify} from '@/vendor/toaster';

const baseURL = document.head.querySelector('meta[name="api-base-url"]').content;

const Api = axios.create({
    //set default endpoint API
    baseURL: baseURL
})

export default Api

export const errorHandler = (error) => {
    let selferrors = error;
    if (error.response) {
        selferrors = JSON.stringify(error.response.data);
    } else if (error.request) {
        selferrors = error.request;
    } else {
        selferrors = error.message;
    }
    notify('error', selferrors)
}
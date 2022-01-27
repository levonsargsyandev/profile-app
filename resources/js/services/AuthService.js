import axios from "axios";
axios.defaults.withCredentials = true;

export default class AuthService {
    async register(data) {
        return await axios.post(this.getUrl('register'), data);
    }

    async auth() {
        return await axios.get('/sanctum/csrf-cookie');
    }

    async login(data) {
        return await axios.post(this.getUrl('login'), data);
    }

    async logout() {
        return await axios.post(this.getUrl('logout'));
    }

    getUrl(url) {
        return `${window.origin}/api/${url}`;
    }
}

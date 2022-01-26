import axios from "axios";

export default class AuthService {
    async register(data) {
        return await axios.post(this.getUrl('register'), data);
    }

    async login(data) {
        return await axios.post(this.getUrl('login'), data);
    }

    async logout() {
        return await axios.get(this.getUrl('logout'));
    }

    getUrl(url) {
        return `${window.origin}/api/${url}`;
    }
}

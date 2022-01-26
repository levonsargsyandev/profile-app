import axios from "axios";

export default class UserService {
    async getUser(data) {
        return await axios.get(this.getUrl('user'), data);
    }

    getUrl(url) {
        return `${window.origin}/api/${url}`;
    }
}

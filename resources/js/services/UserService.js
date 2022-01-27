import axios from "axios";
axios.defaults.withCredentials = true;

export default class UserService {
    async getExperiences() {
        return await axios.get(this.getUrl('experiences'));
    }

    async getOrganizations() {
        return await axios.get(this.getUrl('organizations'));
    }

    async updateUser(data) {
        return await axios.post(this.getUrl('user'), data);
    }

    async updateExperience(data, experienceId) {
        return await axios.put(this.getUrl(`experiences/${experienceId}`), data);
    }

    async updateOrganization(data, organizationId) {
        return await axios.put(this.getUrl(`organizations/${organizationId}`), data);
    }

    async createExperience(data) {
        return await axios.post(this.getUrl('experiences'), data);
    }

    async createOrganization(data) {
        return await axios.post(this.getUrl('organizations'), data);
    }

    getUrl(url) {
        return `${window.origin}/api/${url}`;
    }
}

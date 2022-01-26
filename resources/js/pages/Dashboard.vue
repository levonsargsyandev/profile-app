<template>
    <div>
        <NavBar :is-logged-in="true"></NavBar>
        <div v-if="user" class="w-50 p-5">
            <div class="mb-5">
                <div class="position-relative">
                    <h3 class="mb-4">Personal Info</h3>
                    <b-list-group flush>
                        <b-list-group-item><b>First Name - </b>{{ user.first_name || '-' }}</b-list-group-item>
                        <b-list-group-item><b>Last Name - </b>{{ user.last_name || '-' }}</b-list-group-item>
                        <b-list-group-item><b>Email - </b>{{ user.email || '-' }}</b-list-group-item>
                    </b-list-group>
                    <b-icon @click="setPersonalInfo" v-b-modal.modal-personal-info icon="pencil"
                            class="cursor-pointer pencil"></b-icon>
                </div>
            </div>
            <div>
                <h3 class="mb-4">Work Experience</h3>

                <div v-for="(experience, index) in user.experience" :key="`experience-${index}`"
                     class="position-relative mb-5 pb-5 break-border">
                    <b-list-group flush>
                        <b-list-group-item><b>Company Name - </b>{{ experience.company_name || '-' }}
                        </b-list-group-item>
                        <b-list-group-item><b>Role - </b>{{ experience.role || '-' }}</b-list-group-item>
                        <b-list-group-item><b>Date - </b>({{ experience.start_date || '-' }} -
                            {{ experience.end_date || 'Present' }})
                        </b-list-group-item>
                        <b-list-group-item><b>Description - </b>{{ experience.description || '-' }}</b-list-group-item>
                    </b-list-group>

                    <b-icon @click="setExperience(experience)" v-b-modal="`modal-experience-${index}`" icon="pencil"
                            class="cursor-pointer pencil"></b-icon>

                    <b-modal :id="`modal-experience-${index}`" centered title="Work Experience">
                        <b-form ref="personalInfo" @submit.prevent="updateExperience">
                            <b-form-group>
                                <b-form-input
                                    v-model="selectedExperience.companyName"
                                    type="text"
                                    placeholder="First Name"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group>
                                <b-form-input
                                    v-model="selectedExperience.role"
                                    type="text"
                                    placeholder="Last Name"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group>
                                <b-form-datepicker v-model="selectedExperience.startDate"
                                                   class="mb-2"></b-form-datepicker>
                            </b-form-group>
                            <b-form-group>
                                <b-form-datepicker
                                    v-model="selectedExperience.endDate"
                                    class="mb-2"
                                    reset-button
                                    :disabled="selectedExperience.present"
                                ></b-form-datepicker>
                            </b-form-group>
                            <b-form-group>
                                <b-form-checkbox
                                    v-model="selectedExperience.present"
                                    :value="true"
                                    :unchecked-value="false"
                                    :checked="selectedExperience.present"
                                    :disabled="Boolean(selectedExperience.endDate)"
                                >
                                    I am currently working in this role
                                </b-form-checkbox>
                            </b-form-group>
                            <b-form-group>
                                <b-form-input
                                    v-model="selectedExperience.description"
                                    type="text"
                                    placeholder="Email"
                                ></b-form-input>
                            </b-form-group>
                        </b-form>
                    </b-modal>
                </div>
            </div>
            <div>
                <h3>Organization Associations</h3>
            </div>
        </div>
        <div v-else>
            <h3 class="text-muted text-center mt-5">No Data</h3>
        </div>

        <!-- Personal Info Modal -->
        <b-modal id="modal-personal-info" centered title="Personal Info">
            <b-form ref="personalInfo" @submit.prevent="updatePersonalInfo">
                <b-form-group>
                    <b-form-input
                        v-model="personalInfo.firstName"
                        type="text"
                        placeholder="First Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group>
                    <b-form-input
                        v-model="personalInfo.lastName"
                        type="text"
                        placeholder="Last Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group>
                    <b-form-input
                        v-model="personalInfo.email"
                        type="email"
                        placeholder="Email"
                    ></b-form-input>
                </b-form-group>
            </b-form>
        </b-modal>

        <!-- End Personal Info Modal -->
    </div>
</template>

<script>

import NavBar from "../components/NavBar";
import UserService from "../services/UserService";

export default {
    name: "Dashboard",
    components: {NavBar},
    data() {
        return {
            user: null,
            noData: false,
            personalInfo: {
                firstName: '',
                lastName: '',
                email: ''
            },
            selectedExperience: {
                companyName: '',
                role: '',
                startDate: '',
                endDate: '',
                present: '',
                description: ''
            }
        }
    },

    mounted() {
        this.authService = new UserService();
        this.getUser();

    },

    methods: {
        getUser() {
            this.authService.getUser().then((response) => {
                this.user = response.data;
                console.log(this.user);

            })
        },

        setPersonalInfo() {
            this.personalInfo.firstName = this.user.first_name;
            this.personalInfo.lastName = this.user.last_name;
            this.personalInfo.email = this.user.email;
        },

        setExperience(experience) {
            this.selectedExperience.companyName = experience.company_name;
            this.selectedExperience.role = experience.role;
            this.selectedExperience.startDate = experience.start_date;
            this.selectedExperience.endDate = experience.end_date;
            this.selectedExperience.present = Boolean(experience.present);
            this.selectedExperience.description = experience.description;

        },

        updatePersonalInfo() {

        },

        updateExperience(){
        //    add filter to format date
        }
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}

.pencil {
    position: absolute;
    top: 50%;
    right: -45px
}

.break-border {
    border-bottom: 4px solid;
}
</style>

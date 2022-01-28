<template>
    <div>
        <NavBar></NavBar>
        <div v-if="user" class="w-50 p-5">

            <!-- Personal Info -->

            <div class="mb-5">
                <div class="position-relative">
                    <h3 class="mb-4">Personal Info</h3>
                    <b-list-group flush>
                        <b-list-group-item><b>First Name - </b>{{ user.first_name || 'not exist' }}</b-list-group-item>
                        <b-list-group-item><b>Last Name - </b>{{ user.last_name || 'not exist' }}</b-list-group-item>
                        <b-list-group-item><b>Email - </b>{{ user.email }}</b-list-group-item>
                    </b-list-group>
                    <b-icon @click="setPersonalInfo" v-b-modal.modal-personal-info icon="pencil"
                            class="cursor-pointer pencil"></b-icon>
                </div>
            </div>

            <!-- Work Experiences -->

            <h3 class="mb-4">Work Experience</h3>

            <div>
                <b-button v-b-modal.modal-create-experience class="my-3 btn-success">Create Experience</b-button>
            </div>

            <div>
                <div v-for="(experience, index) in experiences" :key="`experience-${index}`"
                     class="position-relative mb-5 pb-5 break-border">
                    <b-list-group flush>
                        <b-list-group-item><b>Company Name - </b>{{ experience.company_name || 'not exist' }}
                        </b-list-group-item>
                        <b-list-group-item><b>Role - </b>{{ experience.role || 'not exist' }}</b-list-group-item>
                        <b-list-group-item><b>Date - </b>({{ formatDate(experience.start_date) || 'not exist' }} -
                            {{ formatDate(experience.end_date) || (experience.present ? 'Present' : 'not exist') }})
                        </b-list-group-item>
                        <b-list-group-item><b>Description - </b>{{ experience.description || 'not exist' }}
                        </b-list-group-item>
                    </b-list-group>

                    <b-icon @click="setExperience(experience)" v-b-modal="`modal-experience-${index}`" icon="pencil"
                            class="cursor-pointer pencil"></b-icon>

                    <b-modal :id="`modal-experience-${index}`" :experience-id="experience.id" centered
                             title="Work Experience" @ok="updateExperience">
                        <b-form ref="personalInfo">
                            <b-form-group label="Company Name *">
                                <b-form-input
                                    v-model="selectedExperience.companyName"
                                    type="text"
                                    placeholder="Company Name"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group label="Role *">
                                <b-form-input
                                    v-model="selectedExperience.role"
                                    type="text"
                                    placeholder="Role"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group label="Start Date *">
                                <b-form-datepicker
                                    v-model="selectedExperience.startDate"
                                    class="mb-2"
                                ></b-form-datepicker>
                            </b-form-group>
                            <b-form-group label="End Date">
                                <b-form-datepicker
                                    v-model="selectedExperience.endDate"
                                    class="mb-2"
                                    reset-button
                                    :disabled="selectedExperience.present"
                                ></b-form-datepicker>
                            </b-form-group>
                            <b-form-group label="Current Job">
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
                            <b-form-group label="Description (max 300 words)">
                                <b-form-input
                                    v-model="selectedExperience.description"
                                    type="text"
                                    placeholder="Description (max 300 words)"
                                ></b-form-input>
                            </b-form-group>
                            <p v-if="isIncorrectExperienceData" class="text-danger small px-1 pt-1">
                                {{ isIncorrectExperienceData }}</p>
                        </b-form>
                    </b-modal>
                </div>
            </div>

            <!-- Organization Associations -->

            <div>
                <h3 class="mb-4">Organization Associations</h3>

                <div>
                    <b-button v-b-modal.modal-create-organization class="my-3 btn-success">Create Organization Association
                    </b-button>
                </div>

                <div v-for="(organization, index) in organizations" :key="`organization-${index}`"
                     class="position-relative mb-5 pb-5 break-border">
                    <b-list-group flush>
                        <b-list-group-item><b>Organization Name - </b>{{
                                organization.organization_name || 'not exist'
                            }}
                        </b-list-group-item>
                        <b-list-group-item><b>Associated as - </b>{{ organization.association || 'not exist' }}
                        </b-list-group-item>
                        <b-list-group-item><b>Date - </b>({{ formatDate(organization.start_date) || 'not exist' }} -
                            {{
                                formatDate(organization.end_date) || (organization.present ? 'Present' : 'not exist')
                            }})
                        </b-list-group-item>
                        <b-list-group-item><b>Description - </b>{{ organization.description || 'not exist' }}
                        </b-list-group-item>
                    </b-list-group>

                    <b-icon @click="setOrganization(organization)" v-b-modal="`modal-organization-${index}`"
                            icon="pencil"
                            class="cursor-pointer pencil"></b-icon>

                    <b-modal :id="`modal-organization-${index}`" :organization-id="organization.id" centered
                             title="Organization Associations" @ok="updateOrganization">
                        <b-form ref="personalInfo">
                            <b-form-group label="Organization Name *">
                                <b-form-input
                                    v-model="selectedOrganization.organizationName"
                                    type="text"
                                    placeholder="Organization Name"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group label="Organization Association *">
                                <b-form-input
                                    v-model="selectedOrganization.association"
                                    type="text"
                                    placeholder="Associated as"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group label="Start Date *">
                                <b-form-datepicker
                                    v-model="selectedOrganization.startDate"
                                    class="mb-2"
                                ></b-form-datepicker>
                            </b-form-group>
                            <b-form-group label="End Date">
                                <b-form-datepicker
                                    v-model="selectedOrganization.endDate"
                                    class="mb-2"
                                    reset-button
                                    :disabled="selectedOrganization.present"
                                ></b-form-datepicker>
                            </b-form-group>
                            <b-form-group label="Current Job">
                                <b-form-checkbox
                                    v-model="selectedOrganization.present"
                                    :value="true"
                                    :unchecked-value="false"
                                    :checked="selectedOrganization.present"
                                    :disabled="Boolean(selectedOrganization.endDate)"
                                >
                                    I am currently working in this role
                                </b-form-checkbox>
                            </b-form-group>
                            <b-form-group label="Description (max 100 words)">
                                <b-form-input
                                    v-model="selectedOrganization.description"
                                    type="text"
                                    placeholder="Description (max 100 words)"
                                ></b-form-input>
                            </b-form-group>
                            <p v-if="isIncorrectOrganizationData" class="text-danger small px-1 pt-1">
                                {{ isIncorrectOrganizationData }}</p>
                        </b-form>
                    </b-modal>
                </div>
            </div>
        </div>

        <div v-else>
            <h3 class="text-muted text-center mt-5">No Data</h3>
        </div>

        <!-- Personal Info Modal -->
        <b-modal id="modal-personal-info" centered title="Personal Info" @ok="updatePersonalInfo">
            <b-form ref="personalInfo">
                <b-form-group label="First Name *">
                    <b-form-input
                        v-model="personalInfo.firstName"
                        type="text"
                        placeholder="First Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Last Name">
                    <b-form-input
                        v-model="personalInfo.lastName"
                        type="text"
                        placeholder="Last Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Email (unique) *">
                    <b-form-input
                        v-model="personalInfo.email"
                        type="email"
                        placeholder="Email"
                    ></b-form-input>
                </b-form-group>
                <p v-if="isIncorrectPersonalData" class="text-danger small px-1 pt-1">{{ isIncorrectPersonalData }}</p>
            </b-form>
        </b-modal>

        <!-- End Personal Info Modal -->

        <!-- Create Experience Modal -->

        <b-modal id="modal-create-experience" centered title="Create Experience" @ok="createExperience"
                 @hidden="resetNewExperience">
            <b-form ref="personalInfo">
                <b-form-group label="Company Name *">
                    <b-form-input
                        v-model="newExperience.companyName"
                        type="text"
                        placeholder="Company Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Role *">
                    <b-form-input
                        v-model="newExperience.role"
                        type="text"
                        placeholder="Role"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Start Date *">
                    <b-form-datepicker
                        v-model="newExperience.startDate"
                        class="mb-2"
                    ></b-form-datepicker>
                </b-form-group>
                <b-form-group label="End Date">
                    <b-form-datepicker
                        v-model="newExperience.endDate"
                        class="mb-2"
                        reset-button
                        :disabled="newExperience.present"
                    ></b-form-datepicker>
                </b-form-group>
                <b-form-group label="Current Job">
                    <b-form-checkbox
                        v-model="newExperience.present"
                        :value="true"
                        :unchecked-value="false"
                        :checked="newExperience.present"
                        :disabled="Boolean(newExperience.endDate)"
                    >
                        I am currently working in this role
                    </b-form-checkbox>
                </b-form-group>
                <b-form-group label="Description (max 300 words)">
                    <b-form-input
                        v-model="newExperience.description"
                        type="text"
                        placeholder="Description (max 300 words)"
                    ></b-form-input>
                </b-form-group>
                <p v-if="isIncorrectCreateExperienceData" class="text-danger small px-1 pt-1">
                    {{ isIncorrectCreateExperienceData }}</p>
            </b-form>
        </b-modal>

        <!-- End Create Experience Modal -->


        <!-- Create Organization Modal -->

        <b-modal id="modal-create-organization" centered title="Create Organization Association"
                 @ok="createOrganization" @hidden="resetNewOrganization">
            <b-form ref="personalInfo">
                <b-form-group label="Organization Name *">
                    <b-form-input
                        v-model="newOrganization.organizationName"
                        type="text"
                        placeholder="Organization Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Organization Association *">
                    <b-form-input
                        v-model="newOrganization.association"
                        type="text"
                        placeholder="Associated as"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Start Date *">
                    <b-form-datepicker
                        v-model="newOrganization.startDate"
                        class="mb-2"
                    ></b-form-datepicker>
                </b-form-group>
                <b-form-group label="End Date">
                    <b-form-datepicker
                        v-model="newOrganization.endDate"
                        class="mb-2"
                        reset-button
                        :disabled="newOrganization.present"
                    ></b-form-datepicker>
                </b-form-group>
                <b-form-group label="Current Job">
                    <b-form-checkbox
                        v-model="newOrganization.present"
                        :value="true"
                        :unchecked-value="false"
                        :checked="newOrganization.present"
                        :disabled="Boolean(newOrganization.endDate)"
                    >
                        I am currently working in this role
                    </b-form-checkbox>
                </b-form-group>
                <b-form-group label="Description (max 100 words)">
                    <b-form-input
                        v-model="newOrganization.description"
                        type="text"
                        placeholder="Description (max 100 words)"
                    ></b-form-input>
                </b-form-group>
                <p v-if="isIncorrectCreateOrganizationData" class="text-danger small px-1 pt-1">
                    {{ isIncorrectCreateOrganizationData }}</p>
            </b-form>
        </b-modal>

        <!-- End Create Organization Modal -->
    </div>
</template>

<script>

import NavBar from "../components/NavBar";
import UserService from "../services/UserService";
import moment from 'moment';

export default {
    name: "Dashboard",
    components: {NavBar},
    data() {
        return {
            user: null,
            noData: false,
            experiences: null,
            organizations: null,
            newExperience: {
                companyName: '',
                role: '',
                startDate: '',
                endDate: '',
                present: false,
                description: ''
            },
            newOrganization: {
                organizationName: '',
                association: '',
                startDate: '',
                endDate: '',
                present: false,
                description: ''
            },
            isIncorrectPersonalData: '',
            isIncorrectExperienceData: '',
            isIncorrectOrganizationData: '',
            isIncorrectCreateExperienceData: '',
            isIncorrectCreateOrganizationData: '',
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
            },

            selectedOrganization: {
                organizationName: '',
                association: '',
                startDate: '',
                endDate: '',
                present: '',
                description: ''
            }
        }
    },

    mounted() {
        this.userService = new UserService();
        this.getUser();
    },

    methods: {
        getUser() {
            this.user = JSON.parse(localStorage.getItem('user'));
            if (!this.user || !this.user.id) {
                return this.$router.push('/login');
            }

            this.getExperiences();
            this.getOrganizations();
        },

        getExperiences() {
            this.userService.getExperiences().then(response => {
                if (response.data.success) {
                    this.experiences = response.data.experiences;
                }
            })
        },

        getOrganizations() {
            this.userService.getOrganizations().then(response => {
                if (response.data.success) {
                    this.organizations = response.data.organizations;
                }
            })
        },

        formatDate(date) {
            if (!date) return '';
            return moment(date).format('MMM YYYY').toUpperCase();
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

        setOrganization(organization) {
            this.selectedOrganization.organizationName = organization.organization_name;
            this.selectedOrganization.association = organization.association;
            this.selectedOrganization.startDate = organization.start_date;
            this.selectedOrganization.endDate = organization.end_date;
            this.selectedOrganization.present = Boolean(organization.present);
            this.selectedOrganization.description = organization.description;

        },

        updatePersonalInfo(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.userService.updateUser(this.personalInfo).then(response => {
                if (response.data.success) {
                    this.isIncorrectPersonalData = '';
                    let user = JSON.stringify(response.data.user);
                    localStorage.setItem('user', user);
                    this.getUser();
                    this.$nextTick(() => {
                        this.$bvModal.hide(bvModalEvt.componentId)
                    })
                } else {
                    this.isIncorrectPersonalData = 'The given data was invalid.';
                }
            }).catch(() => {
                this.isIncorrectPersonalData = 'The given data was invalid.';
            })
        },

        updateExperience(bvModalEvt) {
            bvModalEvt.preventDefault();

            this.userService.updateExperience(this.selectedExperience, bvModalEvt.vueTarget.$attrs['experience-id']).then(response => {
                if (response.data.success) {
                    this.isIncorrectExperienceData = '';
                    this.experiences = response.data.experiences;
                    this.$nextTick(() => {
                        this.$bvModal.hide(bvModalEvt.componentId)
                    })
                } else {
                    this.isIncorrectExperienceData = 'The given data was invalid.';
                }
            }).catch(() => {
                this.isIncorrectExperienceData = 'The given data was invalid.';
            })
        },

        updateOrganization(bvModalEvt) {
            bvModalEvt.preventDefault();

            this.userService.updateOrganization(this.selectedOrganization, bvModalEvt.vueTarget.$attrs['organization-id']).then(response => {
                if (response.data.success) {
                    this.isIncorrectOrganizationData = '';
                    this.organizations = response.data.organizations;
                    this.$nextTick(() => {
                        this.$bvModal.hide(bvModalEvt.componentId)
                    })
                } else {
                    this.isIncorrectOrganizationData = 'The given data was invalid.';
                }
            }).catch(() => {
                this.isIncorrectOrganizationData = 'The given data was invalid.';
            })
        },

        createExperience(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.newExperience.present = Boolean(this.newExperience.present);
            this.userService.createExperience(this.newExperience).then(response => {
                if (response.data.success) {
                    this.isIncorrectCreateExperienceData = '';
                    this.getExperiences();
                    this.$forceUpdate();
                    this.$nextTick(() => {
                        this.$bvModal.hide(bvModalEvt.componentId)
                    })
                } else {
                    this.isIncorrectCreateExperienceData = 'The given data was invalid.';
                }
            }).catch(() => {
                this.isIncorrectCreateExperienceData = 'The given data was invalid.';
            })
        },

        createOrganization(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.newOrganization.present = Boolean(this.newOrganization.present);
            this.userService.createOrganization(this.newOrganization).then(response => {
                if (response.data.success) {
                    this.isIncorrectCreateOrganizationData = '';
                    this.getOrganizations();
                    this.$forceUpdate();
                    this.$nextTick(() => {
                        this.$bvModal.hide(bvModalEvt.componentId)
                    })
                } else {
                    this.isIncorrectCreateOrganizationData = 'The given data was invalid.';
                }
            }).catch(() => {
                this.isIncorrectCreateOrganizationData = 'The given data was invalid.';
            })
        },

        resetNewExperience() {
            this.newExperience.companyName = '';
            this.newExperience.role = '';
            this.newExperience.startDate = '';
            this.newExperience.endDate = '';
            this.newExperience.present = false;
            this.newExperience.description = '';
        },

        resetNewOrganization() {
            this.newOrganization.organizationName = '';
            this.newOrganization.association = '';
            this.newOrganization.startDate = '';
            this.newOrganization.endDate = '';
            this.newOrganization.present = false;
            this.newOrganization.description = '';
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

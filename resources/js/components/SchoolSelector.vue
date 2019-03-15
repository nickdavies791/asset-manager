<template>
    <div class="form-group">
        <label for="school_id">School</label>
        <select v-model="school" class="form-control" id="school_id" name="school_id">
            <option v-for="school in schools" :value="school.id">{{ school.name }}</option>
        </select>
    </div>
</template>

<script>
    export default {
        props: {
            token: {
                String,
                default: null,
            }
        },

        data() {
            return {
                school: null,
                schools: [],
            }
        },

        created() {
            this.getSchools();
        },

        methods: {
            getSchools() {
                axios.get('/api/user/schools', {
                    params: {
                        'api_token': this.token,
                    }
                }).then(response => (this.schools = response.data))
            }
        }
    }
</script>

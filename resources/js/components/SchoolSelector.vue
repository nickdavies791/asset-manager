<template>
    <div class="form-group">
        <label for="school_id">School</label>
        <select class="form-control" id="school_id" name="school">
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

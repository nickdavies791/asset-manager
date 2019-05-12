<template>
    <div class="form-group">
        <label for="type_id">Asset Type</label>
        <select v-model="type" @change="typeChanged" class="form-control" id="type_id" name="type_id">
            <option v-for="type in types" :value="type.id">{{ type.name }}</option>
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
                type: null,
                types: [],
            }
        },

        created() {
            this.getTypes();
        },

        methods: {
            getTypes() {
                axios.get('/api/types', {
                    params: {
                        'api_token': this.token,
                    }
                }).then(response => (this.types = response.data))
            },

            typeChanged() {
                Event.$emit('typeChanged', this.type);
            }
        }
    }
</script>

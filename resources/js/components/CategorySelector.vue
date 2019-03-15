<template>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select v-model="category" class="form-control" id="category_id" name="category">
            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
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
                category: null,
                categories: [],
            }
        },

        created() {
            Event.$on('typeChanged', newType => {
                this.type = newType;
                this.getCategories();
            });
        },

        methods: {
            getCategories() {
                axios.get('/api/categories', {
                    params: {
                        'api_token': this.token,
                        'type': this.type,
                    }
                }).then(response => (this.categories = response.data))
            }
        }
    }
</script>

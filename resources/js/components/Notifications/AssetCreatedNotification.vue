<template>
    <div v-if="alert">
        <div v-for="user in users" class="alert alert-growl alert-primary alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon pr-2"><i class="fas fa-bullhorn"></i></span>
            <span class="alert-inner--text">{{ user }} just created an asset</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                alert: false,
                users: [],
            }
        },

        created() {
            Echo.private('assets')
                .listen('AssetCreated', ({user}) => {
                    this.alert = true;
                    this.users.push(user.name);
                })
        }
    }
</script>
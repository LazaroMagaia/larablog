<template>
    <div>
    </div>
</template>
<script>
export default {
    created(){
        if(!User.loggedIn())
        {
            this.$router.push({name: 'login'})
        }
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        Toast.fire({icon: 'success',title: 'saiu com sucesso'})
        this.$router.push({name:'login'})
    },

    data(){
        return{

        }
    }
}
</script>

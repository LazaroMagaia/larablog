<template>
    <div>
    <Navbar/>
    <Noty/>
    <div class="banner-principal">
        <h1 class="text-center">llmagaia</h1>
        <img src="/images/bmw_m2.jpg" alt="bmw_m2">
    </div>
    <b-row class="row">
        <b-col cols="12" md="9">
            <Posts/>
        </b-col>
        <b-col cols="12" md="3">
            <Sidebar/>
        </b-col>
    </b-row>
    </div>
</template>
<script>
import Posts from '../blogComponent/Posts.vue'
import Sidebar from '../blogComponent/sidebar.vue'
import Navbar from '../blogComponent/NavBar.vue'
import Noty from '../auth/painel/taiwindNoty.vue'
export default {
    data(){
        return{

        }
    },
    components:{
        Posts,
        Sidebar,
        Navbar,
        Noty
    },
}
</script>

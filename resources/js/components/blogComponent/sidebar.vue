<template>
    <div class="sidebar">
        <h3 class="text-center">sobre mim</h3>
        <img src="/images/bmw_m8.jpg" alt="bmw_m8" >
        <p> É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página
            quando analisa a sua mancha gráfica. Logo, o uso de Lorem Ipsum leva a uma distribuição
            mais ou menos normal de letras, ao contrário do uso de "Conteúdo aqui, conteúdo aqui
        </p>
        <p class="categories text-center">Categorias</p>
            <div>
                <ul class="categories" v-for="cat in categories" :key="cat.id">
                    <li class="w-50"><router-link
                    :to="{name:'categoriePost',params:{categorie:cat.name}}">
                    {{cat.name}}</router-link></li>
                </ul>
            </div>
            <div class="clear"></div>
        <div class="redes-sociais-wrapper">
            <p class="redes-sociais-title text-center">Siga-nos</p>
            <div class="redes-sociais">
            <a href="" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="" target="_blank"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            categories:[],
        }
    },
    methods:{
        allCategories(){
        axios.get('/api/auth/categories')
        .then(({data})=>(this.categories = data))
        .catch()
        },
    },
    created(){
        this.allCategories()
    }
}
</script>

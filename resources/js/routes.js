import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import Forgot from './components/auth/Forgot.vue';
import Reset from './components/auth/Reset.vue';
import Logout from './components/auth/Logout.vue';
import Home from './components/blog/Home.vue';
import SinglePost from './components/blog/SinglePost.vue';
import CategoriePost from './components/blog/CategoriePost.vue';
import PainelControle from './components/auth/painel/Home.vue';
import PainelCreate from './components/auth/painel/create.vue';
import PainelUpdate from './components/auth/painel/update.vue';
import PainelCategorie from './components/auth/painel/categories.vue';
import PainelCategorieUpdate from './components/auth/painel/updateCat';
export const routes = [
    //HOME BLOG ROUTES
    { path: '/', component: Home, name:"home" },
    { path: '/singlePost/:slug', component: SinglePost, name:"singlepost" },
    { path: '/categoriePost/:categorie', component: CategoriePost, name:"categoriePost" },
    //LOGIN, LOGOUT,REGISTER,FORGOT AND RESET ROUTES
    { path: '/login', component: Login, name:"login" },
    { path: '/logout', component: Logout, name:"logout" },
    { path: '/register', component: Register, name:"register" },
    { path: '/forgot', component: Forgot, name:"forgot" },
    { path: '/reset/:token', component: Reset, name:"reset" },
    //ADMIN ROUTES
    { path: '/painel', component: PainelControle, name:"painel" },
    { path: '/painel/create', component: PainelCreate, name:"painel-create" },
    { path: '/painel/update/:id', component: PainelUpdate, name:"painel-update" },
    { path: '/painel/categorie', component: PainelCategorie, name:"painel-categorie" },
    { path: '/painel/categorie/:id', component: PainelCategorieUpdate, name:"painel-categorie-update" },
  ]

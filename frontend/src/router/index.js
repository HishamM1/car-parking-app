import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/register',
      name: 'register',
      beforeEnter: guest,
      component: () => import('@/views/Auth/RegisterView.vue')
    },
    {
      path: '/vehicles',
      name: 'vehicles.index',
      beforeEnter: auth,
      component: () => import('@/views/Vehicles/IndexView.vue')
    },
    {
      path: '/login',
      name: 'login',
      beforeEnter: guest,
      component: () => import('@/views/Auth/LoginView.vue')
    },
    {
      path: '/profile',
      name: 'profile.edit',
      beforeEnter: auth,
      component: () => import('@/views/Profile/EditView.vue')
    }
  ]
})

function auth(to, from, next) {
  if (!localStorage.getItem("access_token")) {
    return next({name: "login"})
  }
  next()
}

function guest(to, from, next) {
  if (localStorage.getItem("access_token")) {
    return next({ name: "vehicles.index"})
  }
  next();
}


export default router

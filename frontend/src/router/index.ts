import { createRouter, createWebHistory } from 'vue-router'
import SelectionList from '@/views/SelectionList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'List',
      component: SelectionList
    },
    {
      path: '/detail',
      name: 'Detail',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('@/views/SelectionDetail.vue')
    }
  ]
})

export default router

import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '../components/LoginPage.vue';
import DashboardPage from '../components/DashboardPage.vue';
import CreateAppointment from '../components/CreateAppointment.vue';
import AdminDashboard from '@/components/AdminDashboard.vue';
import RegisterPage from '@/components/RegisterPage.vue';
import AboutUs from '@/components/AboutUs.vue';
import OurTeam from '@/components/OurTeam.vue';
import Contact from '@/components/Contact.vue';




const routes = [
  { path: '/', name: 'Login', component: LoginPage },
  { path: '/register', name: 'Register', component: RegisterPage },
  { path: '/dashboard', name: 'Dashboard', component: DashboardPage, meta: { requiresAuth: true } },
  { path: '/book', name: 'Book', component: CreateAppointment, meta: { requiresAuth: true } },
  { path: '/admin', name: 'AdminDashboard', component: AdminDashboard, meta: { requiresAuth: true, requiresAdmin: true } },
  { path: '/about', name: 'About', component: AboutUs},
  { path: '/team', name: 'Team', component: OurTeam },
  { path: '/contact', name: 'Contact', component: Contact },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const payload = token ? JSON.parse(atob(token.split('.')[1])) : null;
  const isLoggedIn = !!token;
  const isAdmin = payload?.role === 'admin';

  if (to.path === '/register' && isLoggedIn) {
    next('/dashboard');
  } else if (to.meta.requiresAuth && !isLoggedIn) {
    next('/');
  } else if (to.meta.requiresAdmin && !isAdmin) {
    next('/dashboard');
  } else {
    next();
  }
  
});


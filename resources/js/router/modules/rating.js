/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const ratingRouter = {
  path: '/rating',
  component: Layout,
  redirect: 'rating',
  name: 'rating',
  meta: {
    title: 'შეფასება',
    icon: 'chart',
    roles: ['editor', 'teacher', 'student'],
    permissions: [
      {
        role: 'admin',
        access: false,
        redirect: 'login',
      }],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/rating/index'),
      name: 'rating',
      meta: { title: 'შეფასება', icon: 'chart', roles: ['editor', 'teacher'],
        permissions: [
          {
            role: 'admin',
            access: false,
            redirect: 'login',
          }],
      },
    },
  ],
};

export default ratingRouter;


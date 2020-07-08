/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const ratingRouter = {
  path: '/rating',
  component: Layout,
  redirect: 'rating',
  name: 'rating',
  meta: {
    title: 'rating',
    icon: 'chart',
    roles: ['teacher', 'student'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/rating/index'),
      name: 'rating',
      meta: { title: 'rating', icon: 'chart', roles: ['editor', 'teacher'],
      },
    },
  ],
};

export default ratingRouter;


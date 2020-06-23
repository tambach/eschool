/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const newsRouter = {
  path: '/news',
  component: Layout,
  redirect: 'news',
  name: 'news',
  meta: {
    title: 'news',
    roles: ['teacher', 'student'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/news/index'),
      name: 'news',
      meta: { 'title': 'news', 'icon': 'excel' },
    },
    {
      path: 'show/:id',
      component: () => import('@/views/news/show'),
      name: 'newsshow',
      meta: { 'title': 'news', 'icon': 'excel' },
      hidden: true,
    },
  ],
};

export default newsRouter;


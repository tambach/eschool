/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const homeworkRouter = {
  path: '/homework',
  component: Layout,
  redirect: 'homework',
  name: 'homework',
  meta: {
    title: 'homework',
    icon: 'documentation',
    roles: ['teacher', 'student'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/homework/index'),
      name: 'form',
      meta: { 'title': 'homework', 'icon': 'documentation' },
    },
    {
      path: 'create/:id(\\d+)',
      component: () => import('@/views/homework/create'),
      name: 'CreateHomeWork',
      meta: { title: 'createHomeWork', icon: 'edit' },
      hidden: true,
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/articles/Edit'),
      name: 'EditArticle',
      meta: { title: 'editArticle', noCache: true },
      hidden: true,
    },
  ],
};

export default homeworkRouter;


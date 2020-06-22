/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const homeworkRouter = {
  path: '/homework',
  component: Layout,
  redirect: 'homework',
  name: 'homework',
  meta: {
    title: 'დავალება',
    icon: 'documentation',
    roles: ['teacher', 'student'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/homework/index'),
      name: 'form',
      meta: { 'title': 'დავალება', 'icon': 'documentation' },
    },
    {
      path: 'create',
      component: () => import('@/views/homework/create'),
      name: 'CreateHomeWork',
      meta: { title: 'createHomeWork', icon: 'edit' },
      hidden: true,
    },
  ],
};

export default homeworkRouter;


/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const studentsRouter = {
  path: '/students',
  component: Layout,
  redirect: 'students',
  name: 'students',
  meta: {
    title: 'Student List',
    icon: 'user',
    roles: ['teacher', 'administrator'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/students/index'),
      name: 'students',
      meta: { title: 'Student List', icon: 'user', roles: ['teacher', 'administrator'],
      },
    },
  ],
};

export default studentsRouter;


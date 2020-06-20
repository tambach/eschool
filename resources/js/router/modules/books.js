/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const booksRouter = {
  path: '/books',
  component: Layout,
  redirect: 'books',
  name: 'books',
  meta: {
    title: 'წიგნები',
    icon: 'education',
    roles: ['editor', 'teacher', 'student'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/book/index'),
      name: 'form',
      meta: { title: 'წიგნები', icon: 'education',
      },
    },
  ],
};

export default booksRouter;


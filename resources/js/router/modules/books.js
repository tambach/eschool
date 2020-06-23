/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const booksRouter = {
  path: '/books',
  component: Layout,
  redirect: 'books',
  name: 'books',
  meta: {
    title: 'books',
    icon: 'education',
    roles: ['teacher', 'student'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/book/index'),
      name: 'books',
      meta: { title: 'books', icon: 'education',
      },
    },
  ],
};

export default booksRouter;


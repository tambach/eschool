/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const scheduleRouter = {
  path: '/schedule',
  component: Layout,
  redirect: 'schedule',
  name: 'timetable',
  roles: ['teacher', 'student'],
  meta: {
    title: 'timetable',
    icon: 'table',
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/schedule/index'),
      name: 'timetable',
      meta: { title: 'timetable', icon: 'table' },
    },
  ],
};

export default scheduleRouter;
// {
//     path: '/icon',
//         component: Layout,
//     children: [
//     {
//         path: 'index',
//         component: () => import('@/views/icons/index'),
//         name: 'Icons',
//         meta: { title: 'icons', icon: 'icon', noCache: true },
//     },
// ],
// },
// {
//     path: '',
//         component: Layout,
//     redirect: 'dashboard',
//     children: [
//     {
//         path: 'dashboard',
//         component: () => import('@/views/dashboard/index'),
//         name: 'Dashboard',
//         meta: { title: 'Dashboard', icon: 'dashboard', noCache: true },
//     },
// ],
// },

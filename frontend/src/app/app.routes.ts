import { Routes } from '@angular/router';

import { MainLayout } from './layout/main-layout/main-layout';
import { PublicLayout } from './layout/public-layout/public-layout';

import { InitialPage } from './views/initial-page/initial-page';
import { Login } from './views/login/login';
import { Register } from './views/register/register';

import { Home } from './views/home/home';
import { History } from './views/history/history';
import { Progress } from './views/progress/progress';
import { Exercises } from './views/exercises/exercises';
import { Profile } from './views/profile/profile';

export const routes: Routes = [
    {path: '', component: PublicLayout, children: [
        {path: '', component: InitialPage},
        {path: 'login', component: Login},
        {path: 'register', component: Register}
    ]},
    {path: '', component: MainLayout, children: [
        { path: 'home', component: Home },
        { path: 'history', component: History},
        { path: 'progress', component: Progress },
        { path: 'exercises', component: Exercises},
        { path: 'profile', component: Profile }
    ]}
];

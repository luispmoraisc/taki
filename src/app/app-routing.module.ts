import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { AuthGuard, ResolverMenu } from './_common/index';

const appRoutes: Routes = [
	{ 
		path: '', 
		loadChildren: './content/content.module#ContentModule', 
		canActivate : [AuthGuard],
		resolve : {
			menu : ResolverMenu
		}		
	},		
    { path: 'login', component: LoginComponent},    
    { path: '**', redirectTo: '404'}
];

@NgModule({
	imports: [
		RouterModule.forRoot(
			appRoutes
		)
	],
	exports: [
		RouterModule
	],
	providers : [
		ResolverMenu
	]
})

export class AppRoutingModule {}
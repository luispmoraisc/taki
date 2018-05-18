import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ContentComponent } from './content.component';
import { AuthGuard } from './../_common';

const routes: Routes = [
	{
		path: '',
		component: ContentComponent,
		children: [
			{ 
				path: 'dashboard', 
				loadChildren: './dashboard/dashboard.module#DashboardModule'
				,canActivate: [AuthGuard]				
			},
		]
	}
];

@NgModule({
	imports: [
		RouterModule.forChild(routes)
	],
	exports: [
		RouterModule
	],
	providers:[		
	]
})

export class ContentRoutingModule {}
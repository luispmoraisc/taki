import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { DashboardRoutingModule } from './dashboard-routing.module';
import { DashboardComponent } from './dashboard.component';
import { BreadcrumbModule } from './../../_shared';

@NgModule({
	imports: [
		CommonModule,
		DashboardRoutingModule,
		BreadcrumbModule
	],
	declarations: [
		DashboardComponent
	],
})
export class DashboardModule { }

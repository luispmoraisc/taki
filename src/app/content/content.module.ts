import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule,FormsModule,FormGroup,FormControl,Validators,FormBuilder } from '@angular/forms';

import { ContentRoutingModule } from './content-routing.module';
import { ContentComponent } from './content.component';

import { RequestsService, AppInterceptor } from './../_common/index';

import { BreadcrumbModule, HeaderComponent, SidebarComponent, CollapseService } from './../_shared/index';

import { HTTP_INTERCEPTORS, HttpClient, HttpClientModule } from '@angular/common/http';

@NgModule({
	imports: [
		CommonModule,
		ContentRoutingModule,
		HttpClientModule,
		FormsModule,
		BreadcrumbModule
	],
	declarations: [
		ContentComponent,
		HeaderComponent,
		SidebarComponent	
	],	
	providers:[
		RequestsService,
		CollapseService,
		{
	      	provide: HTTP_INTERCEPTORS,
	      	useClass: AppInterceptor,
	      	multi: true,
	    },	    
	]
})

export class ContentModule {}
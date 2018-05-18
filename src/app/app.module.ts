import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule,FormsModule,FormGroup,FormControl,Validators,FormBuilder } from '@angular/forms';
import { Http, HttpModule } from '@angular/http';

import { HTTP_INTERCEPTORS, HttpClientModule, HttpClient } from '@angular/common/http';

import { LoginComponent } from './login/login.component';

import { AuthGuard, AuthService, AppInterceptor } from './_common/index';

import { AlertComponent, AlertService } from './_shared/index';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';


@NgModule({
  declarations: [
  	LoginComponent,
  	AlertComponent,
    AppComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    HttpClientModule,
    AppRoutingModule
  ],
  providers: [
  	AuthGuard,
  	AuthService,
  	AlertService,
  	{
  		provide: HTTP_INTERCEPTORS,
  		useClass: AppInterceptor,
  		multi: true,
  	},
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

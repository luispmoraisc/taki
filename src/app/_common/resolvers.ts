import { Injectable } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { AlertService } from './../_shared';
import { Observable } from 'rxjs';
import { Constants } from './constants';
import 'rxjs/add/operator/map';

import 'rxjs/add/observable/of';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/delay';

@Injectable()
export class ResolverMenu{
	private url : string;
	constructor(
		public http: HttpClient, 
		private router : Router,
		private alertService: AlertService){
		this.url = Constants.END_POINT;
	}
	resolve(state: RouterStateSnapshot): Observable<any>{				
		document.getElementById('spinner').classList.add('loading');
		return this.http.get(this.url + 'menu').catch((error: any) => {					
			if (error.status === 500) {
				this.alertService.error("Erro ao buscar dados", true);
                return Observable.of(false);
            }
            else if(error.status === 401){
            	this.alertService.error("Seu token expirou, faça login novamente", true);
            	this.router.navigate(['/entrar']);
            	return Observable.of(false);
            }
		});
	}
}

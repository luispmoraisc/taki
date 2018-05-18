import { Injectable } from '@angular/core';
import { Http, Headers, Response, BaseRequestOptions } from '@angular/http';
import { 
	Router, 
	CanActivate, 
	ActivatedRouteSnapshot, 
	RouterStateSnapshot 
} from '@angular/router';
import { AlertService } from './../_shared';
import { Observable } from 'rxjs';
import { Constants } from './constants';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/of';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/delay';

@Injectable()
export class AuthService {
	token : string;
	private loginUrl : string;	
	private headers = new Headers({'Content-Type': 'application/x-www-form-urlencoded'});
	
	constructor(private http: Http, private alertService : AlertService,private router: Router){		
		var tokenStorage = JSON.parse(localStorage.getItem('takiTokenStorage'));
		this.token = tokenStorage && tokenStorage.token;
		this.loginUrl = Constants.END_POINT + 'auth';
	}

	isLoggedIn = false;
	msgError : any;
	redirectUrl: string;

	login(username: string, password: string, grant: string): Observable<any>{
		let body = 'username='+username+'&password='+password+'&grant_type='+grant;
		return this.http.post(this.loginUrl,body, {headers: this.headers})
			.map((response: Response) => {				
				let token = response.json().access_token;
				let retorno = response.json();				
				if(token){
					this.token = token;					
					localStorage.setItem('takiTokenStorage', JSON.stringify(retorno));		
					localStorage.setItem('user', JSON.stringify({"name": response.json().user, "access": response.json().access, "id": response.json().id, "caminho": response.json().caminho}))			
					this.isLoggedIn = true;
					return true;
				}else{
					this.isLoggedIn = false;		
					if(response.status === 200){
						this.msgError = {"error_description" : retorno.message};
						return false;
					}
					this.msgError = {"error_description": "Ocorreu algum erro ao fazer login"};
					return false;
				}
			}).catch((error: Response) => {						
				// retorno de erros específicos para login.
                if (error.status === 500) {
                	this.isLoggedIn = false;
                	this.alertService.error("Erro no servidor");
                    return Observable.of(false);
                }
                else if (error.status === 400) {
                	this.isLoggedIn = false;
                	this.alertService.error("Erro na requisição");
                    return Observable.of(false);
                }
                else if (error.status === 401) {
                	this.isLoggedIn = false;
                	this.alertService.error("Acesso não autorizado");
                    return Observable.of(false);
                }
				else if(error.status === 404){
					this.isLoggedIn = false;
                	this.alertService.error("Página não encontrada");
                	return Observable.of(false);
                }
                else if (error.status === 405) {
                    this.isLoggedIn = false;
                	this.alertService.error("Método não encontrado");
                    return Observable.of(false);
                }
            });	
	}	

	logout(): void{
		this.token = null;
		localStorage.removeItem('takiTokenStorage');
		localStorage.removeItem('user');
		this.isLoggedIn = false;
		this.router.navigate(['/login']);
	}

	getToken(){		
		let tokenStorage = JSON.parse(localStorage.getItem('takiTokenStorage'));			
		return tokenStorage.access_token;
	}

}

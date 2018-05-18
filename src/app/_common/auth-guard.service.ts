import { Injectable } from '@angular/core';
import { 
	Router, 
	CanActivate, 
	ActivatedRouteSnapshot, 
	RouterStateSnapshot 
} from '@angular/router';
import { AuthService } from './auth.service';


@Injectable()
export class AuthGuard implements CanActivate {
	constructor(private authService: AuthService, private router: Router) {}

	canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
		let url: string = state.url;

		return this.checkLogin(url);
	}

	checkLogin(url: string): boolean {
		var token = JSON.parse(localStorage.getItem('takiTokenStorage'));		
		var data = new Date();	
		var newDate = Date.parse(data.toString()); 		
		if (token && (this.authService.isLoggedIn || (token['expire'] > Math.floor(data.getTime()/1000)))) { return true; }

		// Armazenar url de redirecionamento
		this.authService.redirectUrl = url;

		// Se não existe login redirecionar para login
		this.router.navigate(['/login']);
		return false;
	}

	canLoad(route: Router): boolean{
		let url = '/${route.path}';
		return this.checkLogin(url);
	}
}

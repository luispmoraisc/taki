import { Component, OnInit } from '@angular/core';
import { Http, Headers, Response, BaseRequestOptions } from '@angular/http';
import { 
	ReactiveFormsModule,
	FormsModule,
	FormGroup,
	FormControl,
	Validators,
	FormBuilder
 } from '@angular/forms';
import { Usuario } from './../_models';
import { Router } from '@angular/router';
import { AuthService, Constants } from './../_common';
import { AlertService } from './../_shared';

@Component({
	selector: 'app-login',
	templateUrl: './login.component.html',
	styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

	register : boolean = false;		
	grant : string;
	model: any = {};
	modelCadastro : any = {};
	// elementos do login
	frmLogin : FormGroup;
	name : FormControl;
	usernameLogin : FormControl;
	passwordLogin : FormControl;

	// elementos do cadastro
	frmCadastro : FormGroup;	
	// objeto Usuario
	user : Usuario;	

	constructor(
		private authService : AuthService,
		public router : Router,
		private http: Http,
		private alertService : AlertService
	) { }

	login(){					
		document.getElementById('spinner').classList.remove('hidden');
		this.grant = "password";		
		this.authService.login(this.model.username, this.model.password, this.grant).subscribe(()=>{								
			this.hiddenSpinner();
			if(this.authService.isLoggedIn === true){									
				let redirect = this.authService.redirectUrl ? this.authService.redirectUrl : '/dashboard';
				this.router.navigate([redirect]);
			}else{											
				this.alertService.error(this.authService.msgError.error_description);				
			}
		});
	}

	clear(){
		// ao clicar no fechar da mensagem
		this.alertService.clear();
	}

	ngOnInit() {
		this.frmLogin = new FormGroup({
			'usernameLogin': new FormControl(this.model.username, null),
			'passwordLogin': new FormControl(this.model.password, null)
		});

		this.frmCadastro = new FormGroup({
			'name': new FormControl(this.modelCadastro.name, null),
			'username': new FormControl(this.modelCadastro.username, null),
			'password': new FormControl(this.modelCadastro.password, null)
		});
	}

	frmRegister(){		
		this.register = this.register ? false : true;
	}	

	cadastrar(){
		this.alertService.success("Simulação de cadastro do " + this.modelCadastro.name + " efetuada com sucesso");
		this.frmRegister();
	}

	hiddenSpinner(){
		setInterval(() => {
			document.getElementById('spinner').classList.add('hidden');	
		}, 1000);		
	}
}

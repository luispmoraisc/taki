export class Usuario{
	constructor(		
		public name : string,
		public username : string,
		public password : string
	){}

	public static get USER(): string { 		
		return JSON.parse(localStorage.getItem('takiTokenStorage'));
	};
}
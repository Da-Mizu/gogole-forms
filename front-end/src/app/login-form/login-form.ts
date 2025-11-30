import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-login-form',
  imports: [],
  templateUrl: './login-form.html',
  styleUrl: './login-form.css',
})
export class LoginForm {
  constructor(private http: HttpClient) {}
  onSubmit() {
    console.log('Login form submitted');
    const data = { username: 'test', password: '1234' };

    this.http.post<any>('http://localhost/backend/login.php', data).subscribe((response) => {
      console.log('Réponse du serveur:', response);
    });
  }
}

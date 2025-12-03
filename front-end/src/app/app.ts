import { Component, signal } from '@angular/core';
import * as CryptoJS from 'crypto-js';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.css',
})
export class App {
  protected readonly title = signal('front-end');

  onLogin(event: Event) {
    event.preventDefault();
    const form = event.target as HTMLFormElement;
    const username = (form.querySelector('#username') as HTMLInputElement)?.value;
    const password = (form.querySelector('#password') as HTMLInputElement)?.value;
    // Hash le mot de passe
    const hashedPassword = CryptoJS.SHA256(password).toString(CryptoJS.enc.Hex);
    console.log('Tentative de connexion...' + username + password + hashedPassword);

    fetch('/server/login_check.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username, password: hashedPassword }),
    })
      .then(async (response) => {
        const data = await response.json();
        if (response.ok && data.success) {
          // Connexion réussie
          console.log('Utilisateur connecté:', data.user);
        } else {
          // Erreur de connexion
          alert(data.error || 'Utilisateur ou mot de passe incorrect');
        }
      })
      .catch(() => {
        alert('Erreur de connexion au serveur');
      });
  }
}

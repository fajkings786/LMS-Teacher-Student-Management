{{-- <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            margin-bottom: 14px;
            font-size: 15px;
            transition: 0.2s;
        }

        input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #6366f1;
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #4f46e5;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
            margin-top: 15px;
            text-align: center;
        }

        .muted a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 14px;
            font-size: 14px;
            text-align: center;
        }

        .success {
            background: #ecfdf5;
            color: #065f46;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div id="app" class="card">
        <h2>Create Account</h2>

        <form @submit.prevent="submit">
            @csrf
            <div v-if="message" :class="['alert', success ? 'success' : 'error']">@{{ message }}</div>

            <input v-model="name" type="text" placeholder="Full name" required />
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required minlength="6" />

            <button type="submit" :disabled="loading">
                <span v-if="loading">Sending...</span>
                <span v-else>Register</span>
            </button>
        </form>

        <div class="muted">Already registered? <a href="/login">Login</a></div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        const {
            createApp
        } = Vue;
        createApp({
            data() {
                return {
                    name: '',
                    email: '',
                    password: '',
                    message: '',
                    success: false,
                    loading: false
                }
            },
            methods: {
                async submit() {
                    this.message = '';
                    this.success = false;
                    this.loading = true;

                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        let res = await fetch('/register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json', // ✅ Add this
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                name: this.name,
                                email: this.email,
                                password: this.password
                            })
                        });


                        let data = await res.json();

                        if (!res.ok) throw data;

                        this.message = data.message || 'Request sent to Admin ';
                        this.success = true;

                        // Clear form
                        this.name = this.email = this.password = '';

                        // ✅ Redirect to OTP verify page after 1.5s
                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        }

                    } catch (err) {
                        this.message = err.message || err.error || 'Something went wrong ❌';
                        this.success = false;
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }).mount('#app');
    </script>
</body>

</html> --}}
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    @vite('resources/js/app.js')
</head>

<body>
    <div id="app">
        <register-form></register-form>
    </div>
</body>

</html>

<x-dashboard-layout title="Assinar Pro" active="index">
    <div style="max-width:560px;margin:clamp(12px,4vw,36px) auto;">
        <a href="{{ route('dashboard.index') }}" style="display:inline-block;margin-bottom:18px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;text-decoration:none;">← Voltar ao painel</a>

        <div style="background:#fff;border:1px solid #ece9e0;border-radius:22px;padding:clamp(24px,4vw,36px);">
            <div style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#8a9690;margin-bottom:8px;">Assinatura mensal</div>
            <h1 style="font:700 clamp(26px,4vw,32px)/1.05 'Oswald',sans-serif;color:#1b2520;margin:0 0 10px;">PersonalBio Pro · R$ {{ number_format($price, 2, ',', '.') }}/mês</h1>
            <p style="font:400 15px/1.55 'Inter',sans-serif;color:#6b7670;margin:0 0 22px;">Sem a marca PersonalBio, com seu logo e sem limites. Cobrança automática todo mês no cartão de crédito. Cancele quando quiser, pelo painel.</p>

            <div id="checkout-error" role="alert" style="display:none;background:#fbecea;border:1px solid #f0cfc9;color:#8a2f22;border-radius:12px;padding:12px 16px;margin-bottom:16px;font:500 14px/1.4 'Inter',sans-serif;"></div>

            <div id="cardPaymentBrick_container"></div>

            <p style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin:16px 0 0;text-align:center;">🔒 Pagamento processado pelo Mercado Pago. Os dados do cartão não passam pelo PersonalBio e você não precisa ter conta no Mercado Pago.</p>
        </div>
    </div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        (function () {
            const errorBox = document.getElementById('checkout-error');
            const showError = (msg) => { errorBox.textContent = msg; errorBox.style.display = 'block'; };

            const mp = new MercadoPago(@json($publicKey), { locale: 'pt-BR' });

            mp.bricks().create('cardPayment', 'cardPaymentBrick_container', {
                initialization: {
                    amount: @json($price),
                    payer: { email: @json($email) },
                },
                customization: {
                    paymentMethods: { maxInstallments: 1, types: { excluded: ['debit_card'] } },
                    visual: {
                        texts: { formSubmit: 'Assinar por R$ {{ number_format($price, 2, ',', '.') }}/mês' },
                        style: { customVariables: { baseColor: '#1f4733' } },
                    },
                },
                callbacks: {
                    onReady: () => {},
                    onSubmit: (cardFormData) => new Promise((resolve, reject) => {
                        errorBox.style.display = 'none';

                        fetch(@json(route('billing.subscribe')), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': @json(csrf_token()),
                            },
                            body: JSON.stringify({ token: cardFormData.token }),
                        })
                            .then(async (res) => {
                                const data = await res.json().catch(() => ({}));
                                if (res.ok && data.redirect) {
                                    resolve();
                                    window.location.href = data.redirect;
                                } else {
                                    showError(data.message || 'Não foi possível concluir a assinatura. Tente novamente.');
                                    reject();
                                }
                            })
                            .catch(() => {
                                showError('Falha de conexão. Verifique sua internet e tente novamente.');
                                reject();
                            });
                    }),
                    onError: (error) => {
                        console.error(error);
                        if (error && error.type === 'critical') showError('Não foi possível carregar o formulário de pagamento. Recarregue a página.');
                    },
                },
            });
        })();
    </script>
</x-dashboard-layout>

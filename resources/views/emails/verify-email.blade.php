<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email</title>
</head>
<body style="margin:0;padding:0;background-color:#1d4ed8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">

    {{-- Gradient wrapper --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0"
           style="background:linear-gradient(to bottom,#3b82f6,#2563eb,#1e3a8a);min-height:100vh;">
        <tr>
            <td align="center" style="padding:48px 16px;">

                {{-- Card --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                       style="max-width:520px;">
                    <tr>
                        <td style="background:rgba(255,255,255,0.1);
                                   border:1px solid rgba(255,255,255,0.2);
                                   border-radius:24px;
                                   padding:40px 36px;
                                   box-shadow:0 8px 32px rgba(0,0,0,0.2);">

                            {{-- Logo / app name --}}
                            <p style="margin:0 0 32px 0;text-align:center;">
                                <span style="display:inline-block;
                                             background:rgba(255,255,255,0.08);
                                             border:1px solid rgba(255,255,255,0.2);
                                             border-radius:999px;
                                             padding:8px 24px;
                                             color:rgba(236,254,255,0.9);
                                             font-size:18px;
                                             font-weight:500;
                                             letter-spacing:0.01em;">
                                    Task Manager
                                </span>
                            </p>

                            {{-- Heading --}}
                            <h1 style="margin:0 0 12px 0;
                                       text-align:center;
                                       color:rgba(236,254,255,0.9);
                                       font-size:24px;
                                       font-weight:600;
                                       letter-spacing:-0.01em;">
                                Verify your email address
                            </h1>

                            {{-- Body text --}}
                            <p style="margin:0 0 32px 0;
                                      text-align:center;
                                      color:rgba(207,250,254,0.75);
                                      font-size:15px;
                                      line-height:1.6;">
                                Thanks for signing up! Click the button below to confirm your
                                email address and get started.
                            </p>

                            {{-- CTA button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom:32px;">
                                        <a href="{{ $url }}"
                                           style="display:inline-block;
                                                  background:rgba(255,255,255,0.12);
                                                  border:1px solid rgba(255,255,255,0.25);
                                                  border-radius:999px;
                                                  padding:12px 36px;
                                                  color:rgba(236,254,255,0.9);
                                                  font-size:16px;
                                                  font-weight:500;
                                                  text-decoration:none;
                                                  letter-spacing:0.01em;
                                                  box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                                            Verify email address
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Fallback link --}}
                            <p style="margin:0 0 8px 0;
                                      text-align:center;
                                      color:rgba(207,250,254,0.5);
                                      font-size:12px;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>
                            <p style="margin:0;
                                      text-align:center;
                                      word-break:break-all;">
                                <a href="{{ $url }}"
                                   style="color:rgba(165,243,252,0.8);font-size:12px;text-decoration:underline;">
                                    {{ $url }}
                                </a>
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding-top:20px;text-align:center;
                                   color:rgba(207,250,254,0.4);font-size:12px;">
                            If you didn't create an account, you can safely ignore this email.
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>

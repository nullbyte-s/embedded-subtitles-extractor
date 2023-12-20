# Extrator e Conversor de Legendas Embutidas

Este projeto oferece uma solução para extrair e converter legendas complexas para um formato mais simples (SSA para SRT). Desenvolvido para ser executado em servidores Debian e derivados.

## Requisitos

- FFmpeg
- PHP (testado na versão 7.4)

## Configuração

1. Clone este repositório em um diretório acessível pelo seu servidor Web (ex: Apache ou NGINX; `/var/www/php`).
2. Considere a utilização de um autenticador (ex: Authelia) para prevenir acessos não autorizados.
3. Mantenha o usuário e grupo deste diretório idênticos aos arquivos a serem convertidos ou ajuste as permissões conforme necessário (ex: adicionar permissões ao grupo `www-data`).
4. Na linha 4 do arquivo `backend/executar_script.php`, altere o caminho `/home/user/Media/Sample` para o caminho correto da sua pasta de mídias.
5. Na linha 7, substitua "user" pelo nome de usuário que executará o script Bash de conversão.
6. Na linha 2 do arquivo `backend/navegar_legenda.php`, repita o procedimento do passo 4 para `$baseDir`.
7. No terminal, execute `sudo visudo`. Adicione as seguintes linhas no final do arquivo, fazendo as adaptações para o seu sistema:

```bash
user ALL=(ALL) NOPASSWD:ALL
www-data ALL=(user) NOPASSWD: /var/www/php/embedded-subtitles-extractor/scripts/converter_SSA-SRT.sh
```

8. Para salvar, pressione "CTRL+X", "S" ou "Y" (conforme o locale do sistema) e "ENTER".
9. Ajuste as permissões para tornar o script Bash executável (ex: `chmod +x /var/www/php/embedded-subtitles-extractor/scripts/converter_SSA-SRT.sh`).

## A Fazer

- Criar script para simplificar os passos da configuração.
- Desenvolver script para operar a extração e conversão com base em diretórios.
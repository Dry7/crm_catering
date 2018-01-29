set :deploy_to, '/home/b/barkekmail/public_html'
set :tmp_dir, '/home/b/barkekmail/tmp'

ask(:password, nil, echo: false)
 server '77.222.61.238',
   user: 'barkekmail',
   password: fetch(:password),
   roles: %w{web app}
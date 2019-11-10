server '44.225.64.56',
user: 'ubuntu',
roles: %w{web app},
ssh_options: {
   keys: %w(/home/dry7/aws/coffee.pem),
   forward_agent: false,
   auth_methods: %w(publickey)
}
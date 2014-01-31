# -*- mode: ruby -*-
# vi: set ft=ruby :

boxes = [
  {
    :name   => :blogit,
    :play   => :simplefront,
    :ip     => '192.168.205.205',
    :cpus   => 1,
    :memory => 2024
  },
]

Vagrant.configure("2") do |config|

  boxes.each do |opts|

    config.vm.define opts[:name] do |config|

      config.vm.box = "precise64"
      config.vm.box_url = "http://files.vagrantup.com/precise64.box"
      config.vm.hostname = "%s" % opts[:name].to_s
      config.vm.synced_folder ".", "/vagrant", :nfs => true
      config.vm.network :private_network, ip: opts[:ip]

      config.vm.provision :ansible do |ansible|
        ansible.playbook = "provisioning/%s.yml" % opts[:play].to_s
        ansible.inventory_path = "provisioning/ansible_hosts"
        # ansible.verbose = "vvv"
      end

      config.vm.provider "virtualbox" do |v|
          v.name = "%s" % opts[:name].to_s
          v.customize ["modifyvm", :id, "--memory", opts[:memory]] if opts[:memory]
          v.customize ["modifyvm", :id, "--cpus", opts[:cpus] ] if opts[:cpus]
          # Uncomment to enable virtualmachine boot debug
          # v.gui = true
      end

    end
  end
end

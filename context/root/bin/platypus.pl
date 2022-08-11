#!/usr/bin/perl -w

use strict; # With 'perl -w' and 'use strict;' you must declare and initiate variables, list the modules etc ...
use File::Path qw(make_path);
use File::Copy;
use Crypt::OpenSSL::X509;
 
=head1 DESCRIPTION
/**
 *
 * ├── demoCA
 * │   ├── cacert.pem
 * │   ├── crl
 * │   ├── index.txt
 * │   ├── newcerts
 * │   ├── private
 * │   │   └── cakey.pem
 * │   └── serial
 * ├── lhsvol
 * ├── openssl
 * └── openssl.pl
 *
 * @author Radek Kádner
 */
=cut

=head1 main
start
=cut

my $print = 1; # or $print = 0;
my $makeSystem = 1; # or $makeSystem = 0;

my $ssl = "/usr/bin/openssl";
my $path = "/root/bin";
my $lhsdock = "$path/lhsdock";
my $target = "$lhsdock/certs";
my $demoCA = "$path/demoCA";
my $cert = "$demoCA/cacert.pem";
my $demo = "$path/openssl";

# virtuals's names in array
my @virts = qw/lhs.intranet.local alma.intranet.local lhs.alma.local alma.alma.local alma2.intranet.local alma2.alma.local alma8.intranet.local alma8.alma.local docker.intranet.local docker.traefik.local docker5.intranet.local docker5.traefik.local mamka.intranet.local www.alma.local www.traefik.local/;

&makefiles;
=head1 create
/**
 *
.+.......+....+.....[SHORTENED]--
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [XX]:cz
State or Province Name (full name) []:Czech Republic
Locality Name (eg, city) [Default City]:Klasterec nad Ohri
Organization Name (eg, company) [Default Company Ltd]:lhs
Organizational Unit Name (eg, section) []:intranet.local
Common Name (eg, your name or your server's hostname) []:certification authority
Email Address []:radek.kadner@gmail.com
[root@cfea919b2da5 bin]#
 *
 */
=cut
if (-e $cert) { # if exists
        print "== Certification authority ==\n";
        my $x509 = Crypt::OpenSSL::X509->new_from_file($cert);
        print "subject: ".$x509->subject()."\n";
        print "issuer: ".$x509->issuer()."\n";
        print "notBefore: ".$x509->notBefore()."\n";
        print "notAfter: ".$x509->notAfter()."\n";
=head1 main other x509 params
        print "pubkey: ".$x509->pubkey()."\n";
        print "hash: ".$x509->hash()."\n";
        print "email: ".$x509->email()."\n";
        print "issuer_hash: ".$x509->issuer_hash()."\n";
        print "modulus: ".$x509->modulus()."\n";
        print "exponent: ".$x509->exponent()."\n";
        print "fingerprint_md5: ".$x509->fingerprint_md5() . "\n";
        print "fingerprint_sha256: ".$x509->fingerprint_sha256() . "\n";
        print "as_string: ".$x509->as_string()."\n";

        # see https://metacpan.org/pod/Crypt::OpenSSL::X509
        # my $exts = $x509->extensions_by_oid();
        foreach my $oid (keys %{$exts}) {
              my $ext = ${$exts}{$oid};
              print $oid, " ", $ext->object()->name(), ": ", $ext->value(), "\n";
        }
=cut
} else {
	system "$ssl req -new -x509 -nodes -out /root/bin/demoCA/cacert.pem -keyout /root/bin/demoCA/private/cakey.pem -days 366";
}
unless (-e $cert) { # if not exists
	die "Cert not exists!";
}

my @buff = (); # buffer
&make;

=head1 main
stop
=cut

=head2 data
/**
 *
 * @param $host String
 * @param $virt String
 */
=cut
sub data {
        my ($virt) = @_;
        my ($o, $ou) = $virt =~ m/^(\w+)\.(.*)$/;
        &regpush("$ssl req -new -nodes -out $demo/$virt-reg.pem -keyout $demo/$virt-key.pem -subj \"/C=CZ/ST=Czech Republic/L=Klasterec nad Ohri/O=$o/OU=$ou/CN=$virt/emailAddress=radek.kadner\@gmail.com\"");
        &regpush("$ssl ca -in $demo/$virt-reg.pem -out $demo/$virt.pem");
        # &regpush("scp $demo/$virt.pem $demo/$virt-key.pem lhs\@docker:");
        &regpush("# scp $demo/$virt.pem $demo/$virt-key.pem lhs\@docker:");
}

=head2 make
/**
 *
 * For all virtuals
 *
 */
=cut
sub make {
        foreach my $virt (@virts) {
                chomp($virt);
                my ($o, $ou) = $virt =~ m/^(\w+)\.(.*)$/;
                if (-e "$demo/$virt-key.pem" && -e "$demo/$virt.pem") { # if exists
                        print "== virtual:'$virt', o:'$o', ou:'$ou', cn:'$virt', cert:true ==\n";
                        my $x509 = Crypt::OpenSSL::X509->new_from_file("$demo/$virt.pem");
                        print "subject: ".$x509->subject()."\n";
                        print "notBefore: ".$x509->notBefore()."\n";
                        print "notAfter: ".$x509->notAfter()."\n";
                        # print "openssl ca -config /etc/ssl/openssl.cnf -revoke /root/bin/demoCA/newcerts/01.pem";
                } else {
                        if ($print) {
                                print "== virtual:'$virt', o:'$o', ou:'$ou', cn:'$virt', cert:false ==\n";
                        }
                        &data($virt); # call sub data
                }
                if ($print) {
                        print "\n";
                }
        }
        &syst();
        if (-e $cert) {
		copy($cert, "$target/cacert.pem");
	}
        foreach my $virt (@virts) {
                if (-e "$demo/$virt-key.pem" && -e "$demo/$virt.pem") { # if exists
			copy("$demo/$virt.pem", "$target/$virt.pem");
			copy("$demo/$virt-key.pem", "$target/$virt-key.pem");
		}
	}
}

=head2 regpush
/**
 *
 * Regular expresion and push to buff
 *
 * @param $line String
 */
=cut
sub regpush  {
        my ($line) = @_;
        if ($print) {
                print "$line\n";
        }
        unless ($line =~ /^#/) { # don't starts with char '#'
                push(@buff, $line);
        }
}

=head2 syst
/**
 *
 * To system calls
 *
 */
=cut
sub syst {
        foreach my $key (@buff) {
                print "system(\"$key\")\n";
                if ($makeSystem == 1) {
                        system($key);
                }
        }
}

=head2 makefiles
/**
 *
 * Create dirs and make files
 *
 */
=cut
sub makefiles {
        &createdirs;
        &createfiles;
}

# Create dirs
sub createdirs {
        # if ($print) { print "dirs:\n"; }
        my @dirs = ($path, $demo, "$demoCA", "$demoCA/crl", "$demoCA/newcerts", "$demoCA/private", $lhsdock, $target);
        for my $dir (@dirs) {
                # if ($print) { print "$dir\n"; }
                unless (-d $dir) { # if not exists
                        make_path $dir or die "Failed to create path: $dir";
                }
        }

}

# Create files
sub createfiles {
        # if ($print) { print "files:\n"; }
        my $serial = "$demoCA/serial";
        my @files = ($serial, "$demoCA/index.txt");
        for my $file (@files) {
                # if ($print) { print "$file\n"; }
                unless (-e $file) { # if not exists
                        open(my $fh, ">", $file) or die "Failed to create file: $file";
                        if ($file eq $serial) {
                                print $fh "01\n";
                        }
                        close $fh;
                }
        }
}



# Atak011 Projesi Kurulum Rehberi

Bu rehber, Atak011 projesinin kurulumunu adım adım anlatmaktadır. Lütfen aşağıdaki talimatları dikkatlice takip edin.

## Önkoşullar

1. Docker ve Docker Compose'un kurulu olduğundan emin olun.
2. Composer'ın kurulu olduğundan emin olun.
3. PHP'nin kurulu olduğundan emin olun.
4. Projenin kaynak kodlarını git üzerinden veya başka bir yoldan bilgisayarınıza indirdiğinizden emin olun.

## Kurulum Adımları

### 1. Docker İmajlarını Oluştur

Öncelikle projenin kök dizininde terminal veya komut satırı aracını açın. Ardından aşağıdaki komutu çalıştırarak Docker imajlarını oluşturun:

```bash
docker-compose build
```

### 2. Docker Konteynerlerini Başlat

Docker imajları oluşturulduktan sonra aşağıdaki komutla Docker konteynerlerini başlatın:

```bash
docker-compose up -d
```

### 3. Composer Bağımlılıklarını Kur

Projenin PHP bağımlılıklarını yüklemek için aşağıdaki komutu kullanın:

```bash
composer install
```

### 4. Veritabanı Migrasyonları ve Seed İşlemleri

Veritabanı yapılandırmalarınızı tamamladıysanız, aşağıdaki komutla veritabanı migrasyonlarını ve başlangıç verilerini ekleyin:

```bash
php artisan migrate:fresh --seed
```

## Son Adımlar

Kurulum tamamlandığında, tarayıcınızı açarak projenin çalışıp çalışmadığını kontrol edebilirsiniz. Eğer herhangi bir sorunla karşılaşırsanız, log dosyalarını kontrol ederek hata nedenlerini öğrenmeye çalışabilirsiniz.

---
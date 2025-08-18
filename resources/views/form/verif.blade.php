<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Jadwal Dokter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #1b355b;
            color: white;
            border-radius: 10px;
            padding: 20px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-header h1 {
            font-size: 20px;
            margin: 0;
        }
        .progress-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .progress-bar div {
            width: 25%;
            height: 10px;
            background-color: #d9d9d9;
            border-radius: 5px;
        }
        .progress-bar .active {
            background-color: #5cb3fd;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select,
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input {
            box-sizing: border-box;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-actions .btn-cancel {
            background-color: #f44336;
            color: white;
        }
        .form-actions .btn-submit {
            background-color: #4caf50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Verifikasi Jadwal Dokter</h1>
        </div>
        <div class="progress-bar">
          <div class="progress-step active">1</div>
          <div class="progress-line"></div>
          <div class="progress-step">2</div>
          <div class="progress-line"></div>
          <div class="progress-step">3</div>
          <div class="progress-line"></div>
          <div class="progress-step">4</div>
      </div>
        <form>
            <div class="form-group">
                <label for="poliklinik">Poliklinik</label>
                <select id="poliklinik" name="poliklinik">
                    <option value="">-- Semua --</option>
                    <!-- Tambahkan opsi lainnya di sini -->
                </select>
            </div>
            <div class="form-group">
                <label for="dokter">Dokter</label>
                <select id="dokter" name="dokter">
                    <option value="">- Jadwal Dokter -</option>
                    <!-- Tambahkan opsi lainnya di sini -->
                </select>
            </div>
            <div class="form-group">
                <label for="pelayanan">Pelayanan</label>
                <select id="pelayanan" name="pelayanan">
                    <option value="">-- Semua --</option>
                    <!-- Tambahkan opsi lainnya di sini -->
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal">
            </div>
            <div class="form-group">
                <label for="noWhatsapp">No Whatsapp</label>
                <input type="text" id="noWhatsapp" name="noWhatsapp" placeholder="No. Whatsapp">
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel">Batal</button>
                <button type="submit" class="btn-submit">Lanjutkan</button>
            </div>
        </form>
    </div>
</body>
</html>

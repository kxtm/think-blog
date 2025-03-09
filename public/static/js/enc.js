function enc(plainText,key,iv) {
    const encrypted = CryptoJS.AES.encrypt(plainText, CryptoJS.enc.Utf8.parse(key), {iv: CryptoJS.enc.Utf8.parse(iv)});
    return CryptoJS.enc.Base64.stringify(encrypted.ciphertext);
}

function dec(ciphertext,key,iv) {
    const decrypted = CryptoJS.AES.decrypt(ciphertext, CryptoJS.enc.Utf8.parse(key), {iv: CryptoJS.enc.Utf8.parse(iv)});
    return decrypted.toString(CryptoJS.enc.Utf8);
}

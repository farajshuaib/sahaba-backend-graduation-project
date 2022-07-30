import bcrypt from 'bcrypt'

async function hashPassword(password:string) {
 return await bcrypt.hash(password, 10);
}

async function validatePassword(plainPassword:string, hashedPassword:string) {
 return await bcrypt.compare(plainPassword, hashedPassword);
}

export {hashPassword, validatePassword}
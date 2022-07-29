import express from "express";
import jwt from "jsonwebtoken";

import { SECRET } from "../constant";

const isAuthenticated = (req: express.Request, res: express.Response, next: express.NextFunction) => {
    const token = req.cookies.jwt;

    // check json web token exists & is verified
    // if (token) {
    //     jwt.verify(token, SECRET, (err, decodedToken) => {
    //         if (err) {
    //             console.log(err.message);
    //             res.redirect("/login");
    //         } else {
    //             next();
    //         }
    //     });
    // } else {
    //     res.redirect("/login");
    // }
};




export { isAuthenticated };
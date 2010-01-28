//
//  GalaxySignatureOAuth.h
//  iPhone_GalaxyClientCore
//
//  Created by Adam Venturella on 1/23/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "GalaxyAuthorizationSignature.h"

@interface GalaxySignatureOAuth : NSObject <GalaxyAuthorizationSignature>{

	NSString * method;
	NSString * key;
	NSString * secret;
	NSString * realm;
	NSString * absoluteUrl;
	id additionalParameters;
	
}
@property(nonatomic, retain) NSString * key;
@property(nonatomic, retain) NSString * secret;
@property(nonatomic, retain) NSString * method;
@property(nonatomic, retain) NSString * realm;
@property(nonatomic, retain) NSString * absoluteUrl;
@property(nonatomic, retain) id additionalParameters;

+ (GalaxySignatureOAuth *)signatureWithKey:(NSString *)consumer_key secret:(NSString *)consumer_secret;
@end
